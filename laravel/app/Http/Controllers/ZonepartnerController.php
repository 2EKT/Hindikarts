<?php

namespace App\Http\Controllers;

use App\Models\Zonepartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ZonepartnerController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.zonepartner.view');
    }

    public function create()
    {
        return view('admin.zonepartner.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:zonepartners',
        ]);

        $zonepartner=New Zonepartner;
        $zonepartner->zone_id = $request->zone_id;
        $zonepartner->name = $request->name;
        $zonepartner->email = $request->email;
        $zonepartner->phone = $request->phone;
        $zonepartner->password = Hash::make($request->password);
        $zonepartner->active_status = $request->active_status;
        $zonepartner->wallet_balance = 0;
       
        if($zonepartner->save())
        {
            return redirect('/admin/zonepartner/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/zonepartner/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show(Zonepartner $zonepartner)
    {
        //
    }

    
    public function edit(Zonepartner $zonepartner)
    {
        return view('admin.zonepartner.update',compact('zonepartner'));
    }

    
    public function update(Request $request, Zonepartner $zonepartner)
    {
        $zonepartner->zone_id = $request->zone_id;
        $zonepartner->name = $request->name;
        $zonepartner->email = $request->email;
        $zonepartner->phone = $request->phone;
        if($request->password!='')
        {
            $zonepartner->password = Hash::make($request->password);
        }
        
        $zonepartner->active_status = $request->active_status;

        if($zonepartner->save())
        {
            return redirect('/admin/zonepartner/'.$zonepartner->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/zonepartner/'.$zonepartner->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Zonepartner $zonepartner)
    {
        if ($zonepartner->delete()) {
            return redirect('/admin/zonepartner/')->with('success', 'Deleted Successfully');
        }
    }
}