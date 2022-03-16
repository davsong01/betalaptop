<?php

namespace App\Http\Controllers;

use App\Emails;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pending_emails = Emails::where('status', 'pending')->get();
        return view('dash.admin.email', compact('pending_emails'));
    }

    /**
     * Retry pending emails.
     *
     * @return \Illuminate\Http\Response
     */
    function retryAll(Request $request){
    }

    /**
     * Retry a single pending emails.
     *
     * @return \Illuminate\Http\Response
     */
    function retrySingle($id){

    }
 }
