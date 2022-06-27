<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\FunctionsTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MatrixPositioningController extends Controller
{
    use FunctionsTrait;

    const LEFT =  0;
    const RIGHT =  1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $matrices = $this->matrices($user);
        $current_balance = $this->getWallet($user->id);

        return view('dash.users.matrix.index', compact('matrices', 'current_balance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->wallet() < \App\Setting::first()->value('amount_per_slot')) {
            return redirect()->route('downline.index')->with('error', 'Insufficient funds in wallet');
        }

        $user = User::find(auth()->user()->id);
        $matrices = $this->matrices($user);

        return view('dash.users.matrix.create', [
            'matrices' => $matrices,
        ]);
    }

    /**
     * Store a newly created resource in storage, handled recursively
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
     * @param  App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dash.users.matrix.tree', [
            'user' => $user,
            'matrices' => $this->matrices($user)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return csrf_token();
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

        $request->validate([
            "name" => "required|string|min:3|max:30",
            "email" => 'required|unique:users,email',
            "phone" => "required|string",
            "username" => "required|unique:users,username",
            "password" => "nullable|min:8",
            "childPosition" => "required|in:0,1", // 0|1
            "positioning" => [
                "required",
                "regex:/^(\d+::\d+)$/i", //parentId::parentLevel
            ],
        ]);

        [$parentId, $parentLevel] = explode('::', $request->positioning);
         $childPosition = intval($request->childPosition);

        $attributes = array_merge($request->only([
            'name', 'email', 'phone', 'username'
        ]), [
            'password' => Hash::make($request->password ?: 'pass12345'),
            'parent' => $parentId
        ]);

        $user = User::create($attributes);

        $failed = $this->positioning($parentId, $parentLevel, $childPosition, $user);
        if($failed){
            $user->delete();
            // return response()->json($failed);
            return  back()->with('error', 'Failed');
        }
        return back()->with('message', 'Down-line registration successfully'); // return $user;
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
     *
     */
    private function matrices(User $user){
        if (empty($user->children) || collect($user->children)->filter(fn($item) => $item === null)->count() > 1) {
            $matrices = collect([new User, new User]);
        } else {
            $matrices = User::whereIn('id', collect($user->children))->select(['id', 'sibling', 'parent', 'email', 'username', 'children'])->get();
            if (empty($user->children[self::LEFT]) || !$matrices->contains($user->children[self::LEFT])) {
                $matrices->prepend(new User);
            } else if (empty($user->children[self::RIGHT]) || !$matrices->contains($user->children[self::RIGHT])) {
                $matrices->push(new User);
            }
            $matrices->map(function ($item, $key) use($matrices) {

                if (!empty($item->children)) {
                    $matrices[$key]->mapping = $this->matrices($item);
                } else {
                    if (optional($item)->exists) {
                        $matrices[$key]->mapping = collect([new User, new User]);
                    }
                }
            });
        }

        return $matrices;
    }

    public function reverseSmall($id){
        $children = User::select('id', 'username', 'avatar', 'upline')->whereUpline($id)->get()->toArray();
        // dd($children, $id);

        foreach($children as $child){
            if(User::select('id', 'username', 'passport')->whereUpline($child['id'])->count() > 0){
                $children[] = $this->reverseSmall($child['id']);
            }
        }

        return array_merge($children);
    }

    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>
            'required|email|min:3|unique:users,email|not_regex:/(' . preg_quote(env('APP_DOMAIN')) . ')$/i',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' =>  $validator->errors()->getMessages()['email'][0]], 403);
        }
        return response()->json(['status' => 'success', 'message' => 'email address ' . $request->email . ' is available']);
    }

    public function validateUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:40|min:3|unique:users,username|not_regex:/(admin)/i'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->getMessages()['username'][0]], 403);
        }
        return response()->json(['status' => 'success', 'message' => 'username ' . $request->username . ' is available']);
    }

    public function availablePosition($id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User does not exists'], 403);
        }
        return response()->json(['status' => 'success', 'data'=> $user->children ?? [], 'message' => 'User successfully retrieved' ]);
    }
}
