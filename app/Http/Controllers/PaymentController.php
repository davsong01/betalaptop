<?php

namespace App\Http\Controllers;

use Paystack;
use App\Wallet;
use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FunctionsTrait;

class PaymentController extends Controller
{
    use FunctionsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allTransactions()
    {
        $i = 1;
        if($this->isAdmin()){
           $walletTrans = Transactions::orderBy('created_at', 'DESC')->with('user')->get();
            return view('dash.admin.users.wallet_transactions', compact('walletTrans'));
        }else{
            $walletTrans = Transactions::with('user')->whereUserId(auth()->user()->id)
            ->orderBy('created_at', 'DESC')->get();
            return view('dash.users.transactions.online', compact('walletTrans', 'i'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        request()->amount *= 100;

        try {
           return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            $res = explode("{", $e->getMessage());
            return redirect()->back()->withErrors(['message' => preg_replace('/[^A-Za-z0-9 \:]/', '', $res[array_key_last($res)])]);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        /**
         * TODO: Remember to fix replay payload attack/hack
         */
        $paymentDetails = Paystack::getPaymentData();

        $replay_payload = Transactions::where('transaction_id', $paymentDetails['data']['reference'])->first();

        if($paymentDetails['status'] === true && !$replay_payload){
            $amount = $paymentDetails['data']['amount'] /= 100;

            // log payment into transaction table
            Transactions::updateOrCreate( // updateorcreate method ensures no duplicate trans id
                [
                    'transaction_id' => $paymentDetails['data']['reference']
                ],
                [ 'user_id' => auth()->user()->id,
                'amount' => $amount,
                ]
            );
            
            // Update wallet
            $this->topUpWallet(auth()->user()->id, $amount, $paymentDetails['data']['reference']);

            // Create next level matrix
            if( ($amount + auth()->user()->wallet()) >= \App\Setting::value('amount_per_slot')){
                $this->createNextLevel(auth()->user());
            }
   
            // Log email
            $name = auth()->user()->name;
            $subject = 'Payment received';
            $content = "Dear " . $name . ",<br><br>"
            . "We have received your payment of " . \App\Setting::value('currency').number_format($amount) . "<br><br>"
            . "Your transaction id is: " . $paymentDetails['data']['reference'] . "<br><br>
                Kindly <a href ='" . env('APP_URL') . "/wallet"."'>login to your back office to view your wallet balance and history</a>"
            . "<br><br> Warm Regards";
            $recipient = auth()->user()->email;
           
            $this->sendEmail($name, $recipient, $subject, $content);
         
            return redirect(route('wallet.index'))->with(['message' => 'Top up successful']);
        }
        return redirect(route('wallet.index'))->withErrors(['message' => 'An error occurred with your transaction']);
    }
}
