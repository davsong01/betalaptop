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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(auth()->user()->id);
        $matrices = $this->matrices($user);
        return view('dash.users.matrix.create', [
            'matrices' => $matrices->toArray(),
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
        return csrf_token();
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
            "positioning" => [
                "required",
                "regex:/^(\d+::\d+)$/i", //parentId::parentLevel
            ],
        ]);

        [$parentId, $parentLevel] = explode('::', $request->positioning);
         $childPosition = $request->childPosition ? 1 : 0;

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
        if (empty($user->children)) {
            $matrices = collect([null, null]);
        } else {
            $matrices = User::whereIn('id', collect($user->children))->select(['id', 'sibling', 'parent', 'email', 'username', 'children'])->get();
            if (empty($user->children[self::LEFT]) || !$matrices->contains($user->children[self::LEFT])) {
                $matrices->prepend(null);
            } else if (empty($user->children[self::RIGHT]) || !$matrices->contains($user->children[self::RIGHT])) {
                $matrices->push(null);
            }
            $matrices->map(function ($item, $key) use($matrices) {

                if (!empty($item->children)) {
                    $matrices[$key]->children = collect($this->matrices($item))->map(fn( $i) => $i ? (object) $i : $i );
                } else {
                    if (optional($item)->exists) {
                        $matrices[$key]->children = collect([null, null]);
                    }
                }
            });
        }
        return $matrices;
    }
}
