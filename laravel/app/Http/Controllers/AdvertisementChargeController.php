<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class AdvertisementChargeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.advertisementcharge.view');
    }

   
    public function create()
    {
        return view('admin.advertisementcharge.create');
    }

  
    public function store(Request $request)
    {
        $advertisementcharge=New AdvertisementCharge;
        $advertisementcharge->package_name = $request->package_name;
        $advertisementcharge->package_details = $request->package_details;
        $advertisementcharge->amount = $request->amount;

        if($advertisementcharge->save())
        {
            return redirect('/admin/advertisementcharge/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/advertisementcharge/create')->with('error', 'Something Went Wrong');
        }
    }
    public function show(AdvertisementCharge $advertisementcharge)
    {
        //
    }

    
    public function edit(AdvertisementCharge $advertisementcharge)
    {
        return view('admin.advertisementcharge.update',compact('advertisementcharge'));
    }

   
    public function update(Request $request, AdvertisementCharge $advertisementcharge)
    {
        $advertisementcharge->package_name = $request->package_name;
        $advertisementcharge->package_details = $request->package_details;
        $advertisementcharge->amount = $request->amount;
       
        if($advertisementcharge->save())
        {
            return redirect('/admin/advertisementcharge/'.$advertisementcharge->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/advertisementcharge/'.$advertisementcharge->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(AdvertisementCharge $advertisementcharge)
    {
        if ($advertisementcharge->delete()) {
            return redirect('/admin/advertisementcharge/')->with('success', 'Deleted Successfully');
        }
    }
}