<?php

namespace App\Http\Controllers;

use App\Models\Monthlyfee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;


class MonthlyfeeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.monthlyfee.view');
    }


    public function edit(Monthlyfee $monthlyfee)
    {
        return view('admin.monthlyfee.update',compact('monthlyfee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monthlyfee  $monthlyfee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monthlyfee $monthlyfee)
    {
        $monthlyfee->zone_reg = $request->zone_reg;
        $monthlyfee->zone_monthly = $request->zone_monthly;
        $monthlyfee->district_reg = $request->district_reg;
        $monthlyfee->district_monthly = $request->district_monthly;
        $monthlyfee->block_reg = $request->block_reg;
        $monthlyfee->block_monthly = $request->block_monthly;
        $monthlyfee->employee_reg = $request->employee_reg;
        $monthlyfee->employee_monthly = $request->employee_monthly;
        $monthlyfee->delivery_boy_reg = $request->delivery_boy_reg;
        $monthlyfee->delivery_boy_monthly = $request->delivery_boy_monthly;
       
        if($monthlyfee->save())
        {
            return redirect('/admin/monthlyfee/'.$monthlyfee->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/monthlyfee/'.$monthlyfee->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
}