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
        $data['upline'] = $this->getUpline('Level 3, Left 2', auth()->user()->id)['id'];
        $uplines = $this->getUplines($data['upline']);
        
        // $uplines = $uplines->keys();
      
         // remove parent
        $filteredUplines =  $uplines->filter(function ($value, $key) {
            return $key <> auth()->user()->id;
        });
       
        // dd($filteredUplines);
        
        $value = $filteredUplines[1278];
        // Test uplines individually
        $this->updateUplineMatrix($value->id, 'Level 5, Left 4', 1218); // Test, I think the side in the parent, kindly test properly
        dd('done' , $value);
        foreach($filteredUplines as $u=>$value){
            dd($value);
            $this->updateUplineMatrix($value->id, 'Level 2, Left 2', 1218);
        }

        dd($filteredUplines, 'sd');
        // End
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
