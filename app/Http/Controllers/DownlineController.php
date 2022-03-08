<?php

namespace App\Http\Controllers;

use App\User;
use App\Matrix;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\FunctionsTrait;

class DownlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use FunctionsTrait;
    
    public function index()
    {

        $users = User::whereUpline(auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        $users->map(function ($users){
            $users['position'] = $this->getPosition($users->id, auth()->user()->id);
            return $users;
        });
       
        // $this->getUpline("Level 5, left 3", 1);

        $i = 1;
        return view('dash.users.downlines.index', compact('users', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->wallet() < \App\Setting::first()->value('amount_per_slot')){
            return back()->with('error', 'Insufficient funds in wallet');
        }
        $matrix = Matrix::whereUserId(auth()->user()->id)->get();
           
            $matrix->map(function($matrix){
                $matrix['left'] = json_decode($matrix->left, true);
                $matrix['right'] = json_decode($matrix->right, true);

                return $matrix;
            });
        $level = $matrix->count();
        return view('dash.users.downlines.register', compact('matrix', 'level'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            "name" => "required|string|min:3|max:30",
            "email" => 'required|unique:users,email',
            "phone" => "required|string",
            "username" => "required|unique:users,username",
            "password" => "nullable",
            "position" => "required"
        ]);
        // Check if enough funds
        if(auth()->user()->wallet() < Setting::value('amount_per_slot')){
            return back()->with('error', 'Insufficient funds for tis process');
        }

        // Position must be in available positions
        $avaliablePostions = $this->getOpenPositions(auth()->user()->id, auth()->user()->level());
        
        if(!in_array($request->position, $avaliablePostions)){
            return back()->with('error', 'Invalid Position selected for user');
        }
        // Handle Password Change
        if(request()->has('password')){
            $data['password'] = Hash::make($request['password']);
        }else $data['password'] =  Hash::make('pass12345');
        
        $data['upline'] = $this->getUpline($request->position, auth()->user()->id)['id'];
        $data['parent_id'] = auth()->user()->id;
        
        // deduct amount
        $this->walletWithdraw(auth()->user()->id, Setting::value('amount_per_slot'));
        unset($data['position']);
        
        $user = User::create($data);
        // Update user matrix
       
        $this->updateMatrix(auth()->user(), $request->position, $user->id);

        // Log resgistration email
        $emailContent = "Dear " .$user->name . ",<br><br>"
            . "Welcome to " . env('APP_NAME') . "<br><br>"
            . "An account has been created for you <br><br>
                by: ". auth()->user()->username ."<br>"
            . " On" . $user->created_at->format('Y-m-d H:i:s')
            . " <br><br>
                Your login details are: <br> Email: " . $user->email. "<br>Password: " . $request->password ?? "pass12345 <br><br><br>" 
            . "Kindly <a href ='" . env('APP_URL') . "/wallet"."'>login to your back office to start referring and earning</a> <br><br> Warm Regards <br><br>";
      
        $this->sendEmail($user->name, $user->email, 'Welcome to '. env('APP_NAME'), $emailContent);

        return back()->with('message', 'Registration succesful, an email has been sent to '.$user->email);
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
