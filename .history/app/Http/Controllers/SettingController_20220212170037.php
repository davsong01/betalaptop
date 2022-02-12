<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
    
        return view('dash.admin.settings.update', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        dd($request->all());
        // Create validation
        $data = $this->validate($request,[
            'logo' => 'nullable',
            'favicon' => 'nullable',
            company_name" => "Betalaptops"
  "official_email" => "info@betalaptops.com"
  "official_phone" => null
  "official_bank" => null
  "official_account_name" => null
  "official_account_number" =>

        ]);
        // Handle logo
        if(request()->has('logo')){
            // Upload new
             $request->logo = $this->uploadImage($request->logo, 'site/assets/images/general');
        }

        // Handle favicon
        if(request()->has('favicon')){
            // Upload new
             $request->logo = $this->uploadImage($request->favicon, 'site/assets/images/general');
        }
        $request->request->remove('_token');
        $request->request->remove('_method');
        $setting->update($request->all());
        return back()->with('message', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
