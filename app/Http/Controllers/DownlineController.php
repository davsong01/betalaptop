<?php

namespace App\Http\Controllers;

use App\User;
use App\Matrix;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

        // Create next level if user has enough and all point are filled.
        if((auth()->user()->wallet()) >= \App\Setting::value('amount_per_slot')){
            $this->createNextLevel(auth()->user());
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
            "email" => 'required|unique:users,email|not_regex:/(' . preg_quote(env('APP_DOMAIN')) . ')$/i',
            "phone" => "required|string",
            "username" => "required|unique:users,username|not_regex:/(admin)/i",
            "password" => "nullable|min:8",
            "position" => "required"
        ]);

        // Check if enough funds
        if(auth()->user()->wallet() < Setting::value('amount_per_slot')){
            return back()->with('error', 'Insufficient funds for tis process');
        }

        // Position must be in available positions
        $availablePositions = $this->getOpenPositions(auth()->user()->id, auth()->user()->level());
        // dd(in_array($request->position, array_column($availablePostions, 'name'))), $availablePostions));

        if(!in_array($request->position,  $availablePositions)){
            // dd(  $availablePositions, $request->position);
            return back()->with('error', 'Invalid Position selected for user');
        }

        // Handle Password Change
        if(request()->has('password')){
            $data['password'] = Hash::make($request['password']);
        }else $data['password'] =  Hash::make('pass12345');

        $data['upline'] = $this->getUpline($request->position, auth()->user()->id)['id'];
        $data['parent_id'] = auth()->user()->id;
        // get uplines eloquently from trait
        $data['uplines'] = $this->getUplines(auth()->user()->id)->keys(); // this should pass immediate upline
        foreach  ($data['uplines'] as $key => $value) {
           $this->createUplineNextLevel($value);
        }

        // make next level for chains of uplines

        // deduct amount
        $this->walletWithdraw(auth()->user()->id, Setting::value('amount_per_slot'));
        unset($data['position']);

        $user = User::create($data);
        // Update user matrix

        $this->updateMatrix(auth()->user(), $request->position, $user->id);

        // Get direct upline and place new user in appropraite index
        $newUpline = User::findOrFail($data['upline']);
        $uplinePostion = $this->getLevel( $newUpline->id );
        $this->createUplineNextLevel($newUpline->id );

        // Todo Work on updateMatrix for upline
        // Level 2 - level 1, right 2 = nbetwen, remodify the getUplineIndex function to get position to place this new user in the upline's tree
        if(auth()->user()->level() > 1){
            // $this->updateUplineMatrix($newUpline->id, $request->position, $user->id);
        }
        // Place in appropraite position

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

        return redirect(route('downline.index'))->with('message', 'Registration successful, an email has been sent to '.$user->email);
    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>
            'required|email|min:3|unique:users,email|not_regex:/(' . preg_quote(env('APP_DOMAIN')) . ')$/i',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' =>  $validator->errors()->getMessages()['email'][0]], 404);
        }

        return response()->json(['status' => 'success', 'message' => 'email address ' . $request->email . ' is available']);
    }

    public function validateUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:40|min:3|unique:users,username|not_regex:/(admin)/i'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' =>$validator->errors()->getMessages()['username'][0]], 404);
        }

        return response()->json(['status' => 'success', 'message' => 'username ' . $request->username . ' is available']);
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
