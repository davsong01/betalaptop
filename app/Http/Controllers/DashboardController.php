<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        return view('dash.index');
    }

    public function profile()
    {
        return view('dash.profile')->with('user', auth()->user());
    }

    public function saveProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'string|max:30|required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user = User::find($user->id);
        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }
        return redirect()->back();
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

    public function validateUsernameOrEmail(Request $request)
    {
        return response()->json($request);
        $user = auth()->user();
        $request->validate([
            'usernameOrEmail' => 'string|max:30|required',
        ]);
        return redirect()->back();
    }
}
