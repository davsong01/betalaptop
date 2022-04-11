<?php

namespace App\Http\Controllers;

use App\User;
use App\Matrix;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\FunctionsTrait;
use Illuminate\Support\Facades\Validator;

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
            $user = User::find($id);
            $matrix = Matrix::whereUserId($id)->get();
            
            $matrix->map(function($matrix){
                $matrix['left'] = json_decode($matrix->left, true);
                $matrix['right'] = json_decode($matrix->right, true);

                return $matrix;
            });

        }else{
            $user = User::findorfail($id);
            $heirachy = [];
           
            foreach($this->getDownlines() as $downline){
                $heirachy[] = $downline['id'];
            }
           
            $check = $user->whereIn('id', $heirachy)->first();
           
            // Check if this 
            if($user->id != auth()->user()->id && !in_array($user->id, $heirachy)){
                return back()->with('error', 'invalid user id');
            }

            $level = NULL;
            $matrix = Matrix::whereUserId($user->id)->get();
            
            $matrix->map(function($matrix){
                $matrix['left'] = json_decode($matrix->left, true);
                $matrix['right'] = json_decode($matrix->right, true);

                return $matrix;
            });
        }
        
        $level = $matrix->count();
        return view('dash.users.tree.binary_tree', compact('matrix', 'user', 'level'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dash.admin.users.create');
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
            "password" => "nullable|min:8",
        ]);
        $data['password'] = $data['password'] ? Hash::make($data['password']) : Hash::make('passAdmin');
        User::create($data);

        return redirect()->back()->with('message', 'User created successfully');
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
            return response()->json(['status' => 'error', 'message' => $validator->errors()->getMessages()['username'][0]], 404);
        }

        return response()->json(['status' => 'success', 'message' => 'username ' . $request->username . ' is available']);
    }

    private function validation($request)
    {
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
