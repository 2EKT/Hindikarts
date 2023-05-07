<?php

namespace App\Http\Controllers;

use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;


class ServiceChargeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.service_charge');
    }


    public function edit(ServiceCharge $servicecharge)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCharge  $servicecharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceCharge $servicecharge)
    {
        $servicecharge->value = $request->service_charge;
       
        if($servicecharge->save())
        {
            return redirect('/admin/servicecharge')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/servicecharge')->with('error', 'Something Went Wrong');
        }
    }

    
}