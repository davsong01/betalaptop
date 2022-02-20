<?php

namespace App\Http\Controllers;

use App\User;
use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FunctionsTrait;
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
        return view("dash.users.transactions.index", compact("walletTrans", ));
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
           $this->walletTransfer(auth()->user()->id, $receiver->id, $request->transferAmount);
        //    dd($receiver->id, $request);
            return redirect()->back()->with(['msg' => 'Transfer successful']);
       }
       return redirect()->back()->withErrors(['msg' =>'An error occurred with your transfer']);
    }
}
