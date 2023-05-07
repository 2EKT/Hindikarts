<?php

namespace App\Http\Controllers;

use App\Models\Merchanttype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use Mail;

class MerchanttypeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.merchanttype.view');
    }

   
    public function create()
    {
        return view('admin.merchanttype.create');
    }

  
    public function store(Request $request)
    {
        $merchanttype=New Merchanttype;
        $merchanttype->service_id = $request->service_id;
        $merchanttype->type = $request->type;
        $merchanttype->slug = Str::slug($request->type);
        $merchanttype->registration_fee = $request->registration_fee;
        $merchanttype->monthly_fee = $request->monthly_fee;

        if($merchanttype->save())
        {
            return redirect('/admin/merchanttype/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/merchanttype/create')->with('error', 'Something Went Wrong');
        }
    }
    public function show(Merchanttype $merchanttype)
    {
        //
    }

    
    public function edit(Merchanttype $merchanttype)
    {
        return view('admin.merchanttype.update',compact('merchanttype'));
    }

   
    public function update(Request $request, Merchanttype $merchanttype)
    {
        $merchanttype->service_id = $request->service_id;
        $merchanttype->type = $request->type;
        $merchanttype->slug = Str::slug($request->type);
        $merchanttype->registration_fee = $request->registration_fee;
        $merchanttype->monthly_fee = $request->monthly_fee;
       
        if($merchanttype->save())
        {
            return redirect('/admin/merchanttype/'.$merchanttype->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/merchanttype/'.$merchanttype->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Merchanttype $merchanttype)
    {
        if ($merchanttype->delete()) {
            return redirect('/admin/merchanttype/')->with('success', 'Deleted Successfully');
        }
    }
}