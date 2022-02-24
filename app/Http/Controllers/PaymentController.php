<?php

namespace App\Http\Controllers;

use Paystack;
use App\Transactions;
use App\Wallet;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
        if($this->isAdmin()){
           $walletTrans = Transactions::with('user')->get();
            return view('dash.admin.users.wallet_transactions', compact('walletTrans'));
        }else{
            $walletTrans = Transactions::with('user')->whereUserId(auth()->user()->id)->get();
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
        $paymentDetails = Paystack::getPaymentData();
        if($paymentDetails['status'] === true){
            $this->topUpWallet(auth()->user()->id, $paymentDetails['data']['amount'] /= 100);
            Transactions::create([
                'user_id' => auth()->user()->id,
                'amount' => $paymentDetails['data']['amount'] /= 100,
                'transaction_id' => $paymentDetails['data']['reference']
            ]);
            // log payment into transaction table
            // Update wallet
            // Provide value :
            /**
             * 1. Open level 1 if user has no downlines by creating a new matrix row with position 1
             */
            return redirect()->back()->with(['message' => 'Top up successful']);
        }
        return redirect()->back()->withErrors(['message' => 'An error occurred with your transaction']);
    }
}
