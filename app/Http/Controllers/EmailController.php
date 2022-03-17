<?php

namespace App\Http\Controllers;

use App\Emails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailCron;

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
        $emails = Emails::where('status', 'pending')->get()->take(70);

        foreach ($emails as $email) {
            Mail::to($email->recipient)->send(new EmailCron($email));
        }
        if (count(Mail::failures())) {
            return redirect()->back()->withErrors('error', 'Failed to send mail to: ' . implode(", ",Mail::failures()));
        }
        Emails::destroy($emails->map(function($email) {return $email->id;}));
        return redirect()->back()->with('message', 'Email sent successfully');
    }

    /**
     * Retry a single pending emails.
     *
     * @return \Illuminate\Http\Response
     */
    function retrySingle($id){
        $email =  Emails::findOrFail($id);
       if(Mail::to($email->recipient)->send(new EmailCron($email))){
           return redirect()->back()->withErrors('error', 'Email failed');
       }
       $email->delete();
       return redirect()->back()->with('message', 'Email sent successfully');
    }
 }
