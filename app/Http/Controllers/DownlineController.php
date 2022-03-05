<?php

namespace App\Http\Controllers;

use App\User;
use App\Matrix;
use Illuminate\Http\Request;
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
        // dd($users);
        $i = 1;
        return view('dash.admin.users.index', compact('users', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
