<?php

namespace App\Http\Controllers;

use App\User;
use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FunctionsTrait;
use App\ProofOfPayment;
use App\Wallet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $walletTrans = $this->getWalletHistory(auth()->user()->id);
        $current_balance = $this->getWallet(auth()->user()->id);
        return view("dash.users.transactions.index", compact("walletTrans", 'current_balance'));
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
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transactions)
    {
        //
    }

/**
 * Validate username or email for transfer
 * @return Response
 */
    public function validateUsernameOrEmail(Request $request)
    {
        $request->request->add(['type' =>  filter_var($request->usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username']);

        $validator = Validator::make($request->all(), [
            'type' => 'string|max:40|required|in:email,username',
            'usernameOrEmail' => 'required|string|max:40',
            'usernameOrEmail' => 'exists:users,' . $request->type, // check email/username exist
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid username or email'], 404);
        }

        $user = User::where($request->type, $request->usernameOrEmail)->first();

        if($user->id === auth()->user()->id){

            return response()->json(['status' => 'error', 'message' => 'Invalid username or email'], 404);
        }

        return response()->json(['status' => 'success', 'message' => 'user ' . $request->usernameOrEmail . ' found']);
    }

    /**
     * Validate username or email for transfer
     * @return Redirect
     */
    public function transferFund(Request $request)
    {
        $res = $this->validateUsernameOrEmail($request);
       if ( $res && ($res->getData()->status === "success")){
           $request->validate([
               'transferAmount' => 'numeric|required'
           ]);
           $receiver = User::where('email', $request->usernameOrEmail)->orWhere('username', $request->usernameOrEmail)->first();
          if( $this->walletTransfer(auth()->user()->id, $receiver->id, $request->transferAmount))
            return redirect()->back()->with(['message' => 'Transfer successful']);
       }
       return redirect()->back()->withErrors(['message' =>'Invalid fund, or an error occurred with your transfer, try again.']);
    }

    /**
     * Upload proof of payment
     * @param Request @request
     * @return Redirect
     */
    public function uploadPOP(Request $request){
        $request->validate([
            'proofOfPayment' => 'required|mimetypes:image/*,application/pdf|max:4096',
            'amount' => 'required|numeric'
        ]);

        $file = $request->proofOfPayment;
        $path = $file->store('public/proof-of-payment');
        ProofOfPayment::create([
            'user_id' => auth()->user()->id,
            'path' => $path,
            'name' =>  basename($path),
            'amount' => $request->amount
        ]);
        //TODO: send a mail, to the admin
        return redirect(route('transactions.me.proofOfPayment'))->with(['message' => 'uploaded successfully']);
    }

    //admin method
    public function allProofOfPayment(){
        $files = Storage::disk()->files('public/proof-of-payment');
        return view('dash.admin.users.pop', compact('files'));
    }

    //user method
    public function meProofOfPayment(){
        $proofs = ProofOfPayment::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        return view('dash.users.pops.index', compact('proofs'));
    }

    public function rejectProofOfPayment(string $id){
        $proof = ProofOfPayment::where('name', $id)->first();
        if($this->isAdmin() && $proof && Storage::disk()->exists($proof->path)){
            $proof->status = 'rejected';
            $proof->save();
            Storage::delete($proof->path);
            $proof->delete();

            //TODO: send a mail, to the user
            return redirect()->back()->with(['message' => 'rejected successfully']);
        }
        return redirect()->back()->withErrors(['message' => 'An error occurred, check if file exits or unauthorized to perform this action']);
    }

    public function acceptProofOfPayment(string $id){
        $proof = ProofOfPayment::where('name', $id)->first();
        if($this->isAdmin() && $proof && Storage::disk()->exists($proof->path)){
            $proof->status = 'accepted';
            $proof->save();
            Storage::delete($proof->path);

            Transactions::create([
                'user_id' => $proof->id,
                'amount' => $proof->amount,
                'transaction_id' => $proof->name
            ]);
            Wallet::create([
                'user_id' => $proof->user_id,
                'type' => 'topup',
                'amount' => +$proof->amount,
            ]);
            $proof->delete();
            //TODO: send a mail, to the user
            return redirect()->back()->with(['message' => 'accepted successfully']);
        }
        return redirect()->back()->withErrors(['message' => 'An error occurred, check if file exits or unauthorized to perform this action']);
    }
}
