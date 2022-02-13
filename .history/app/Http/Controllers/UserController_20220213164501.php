<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\FunctionsTrait;


class UserController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use FunctionsTrait;
    
    public function index()
    {
        $users = User::whereRole(2)->orderBy('created_at', 'DESC')->get();
        $i = 1;
        return view('dash.admin.users.index', compact('users', 'i'));
    }

    public function getWalletHistory($id){
        $walletTrans = Wallet::with('user', 'transferRecipient')->whereUserId($id)->orderBy('created_at', 'DESC')->get();
      
        $i = 1;
        return view('dash.admin.users.wallet_transactions', compact('walletTrans', 'i'));
    }

    public function binaryTree($id){

        if($this->isAdmin()){
            $walletTrans = Wallet::with('user', 'transferRecipient')->get();
            return view('dash.admin.users.wallet_transactions', compact('walletTrans', 'i'));
        }else{
            $walletTrans = Wallet::with('user', 'transferRecipient')->whereUserId(auth()->user()->id)->get();
            return view('dash.users.transactions.index', compact('walletTrans', 'i'));

        }
        $matrix = Matrix::whereId($id)->get();
        return view('dash.admin.users.binary_tree', compact('matrix'));

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
    public function edit(User $user)
    {
        return view('dash.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validation($request);
        $data['email'] = $request->email;

        // Special validation for user email
        $this->validate($request, [
           'email' => 'required|unique:users,email,'. $user->id,
        ]);
        
        // Handle avatar upload
        if(request()->has('avatar')){
            //delete old one
            if(isset($user->avatar)){
                $this->deleteImage($user->avatar);
            }
            // Upload new
            $avatar = $this->uploadImage($request->avatar, 'site/assets/images/avatars', '400', '400');
            $data['avatar'] = $avatar;
        }
        
        // Handle Password Change
        if(request()->has('password')){
            $data['password'] = Hash::make($request['password']);
        }else $data['password'] = $user->password;

        // Save
        $user->update($data);

        return back()->with('message', 'Operation successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(isset($user->avatar)){
            $this->deleteImage($user->avatar);
        }
        $user->delete();
        
        return back()->with('message', 'Delete successful');
    }

    private function validation($request){
        $v = $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'avatar' => 'nullable',
            'enrolled_by' => 'nullable',
            'sponsor_id' => 'nullable',
            'upline' => 'nullable',
        ]);

        return $v;
    }
}
