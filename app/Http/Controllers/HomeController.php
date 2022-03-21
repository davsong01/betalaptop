<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FunctionsTrait;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use FunctionsTrait;
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
     public function test(){
        $data['uplines'] = $this->getUplines(1079);
        dd($data['uplines']);
        foreach($data['uplines'] as $user){
            $this->updateAllUplines($data['uplines'], 'Level 2, Right 2');
        }

        // $this->updateAllUplines([$data['uplines'], $user->id]);
     }
     public function index(){
         
         return view('shop.index');
     }
}
