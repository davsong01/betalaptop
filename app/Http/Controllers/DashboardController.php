<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\FunctionsTrait;
class DashboardController extends Controller
{
    use FunctionsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_balance = $this->getWallet(auth()->user()->id);
        $num_of_downlines = User::whereJsonContains('uplines', auth()->user()->id)->count();
        $level = $this->getLevel(auth()->user()->id);
        $transactions = $this->getWalletHistory(auth()->user()->id)->take(5);
        return view('dash.index', compact('current_balance', 'num_of_downlines', 'level', 'transactions'));
    }

    public function profile()
    {
        return view('dash.profile')->with('user', auth()->user());
    }

    public function saveProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:30|required',
            'username' =>  'required|not_regex:/(admin)/i|unique:users,username,' . $user->id,
            'email' => 'required|email|not_regex:/(' . preg_quote(env('APP_DOMAIN')) . ')$/i|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'phone' => 'nullable|min:9|unique:users,phone,' . $user->id,
            'avatar' => 'nullable|mimetypes:image/*|max:1096'
        ]);

        $user = User::find($user->id);
        if (!$user) {
            redirect()->back()->withErrors(['message' => 'Unauthorized request']);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone ?: $user->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;

        if($request->has('avatar')){
            if($user->avatar){
                $this->deleteImage($user->avatar);
            }
            $user->avatar = $this->uploadImage($request->avatar,'site/assets/images/avatars', '400', '400');
        }
        $user->save();

        return redirect()->back()->with('message', 'profile updated successfully');
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
}
