<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ZoneController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.zone.view');
    }

   
    public function create()
    {
        return view('admin.zone.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'district' => 'present|array',
            // 'state_id' => 'required'

        ]);
        // exit('working');
        $zone=New Zone;
        $zone->state_id = $request->state_id;
        $zone->zone_title = $request->zone_title;
        $districts = $request->district;

       
        if($zone->save())
        {
            $last_id=$zone->id;
            foreach($districts as $district_value)
            {
                $res=array(
                    'zone_id'=>$last_id
                );
                DB::table('district')->where('id','=',$district_value)->update($res);
            }
            return redirect('/admin/zone/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/zone/create')->with('error', 'Something Went Wrong');
        }
    }

    
    public function show(Zone $zone)
    {
        //
    }

    
    public function edit(Zone $zone)
    {
        return view('admin.zone.update',compact('zone'));
    }

    
    public function update(Request $request, Zone $zone)
    {
        $zone->state_id = $request->state_id;
        $zone->zone_title = $request->zone_title;
        $districts = $request->district;

        if($zone->save())
        {
            $last_id=$zone->id;
            $check_row=DB::table('district')->where('zone_id','=',$last_id)->get();
            foreach($check_row as $check_result)
            {
                $check_array[]=$check_result->id;
            }

            foreach($check_array as $check_array_value)
            {
                $val=array(
                    'zone_id'=>0
                );
                DB::table('district')->where('id','=',$check_array_value)->update($val);
            }
            
            foreach($districts as $district_value)
            {
                $res=array(
                    'zone_id'=>$last_id
                );
                DB::table('district')->where('id','=',$district_value)->update($res);
            }
            return redirect('/admin/zone/'.$zone->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/zone/'.$zone->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Zone $zone)
    {
        $last_id=$zone->id;
            $check_row=DB::table('district')->where('zone_id','=',$last_id)->get();
            foreach($check_row as $check_result)
            {
                $check_array[]=$check_result->id;
            }

            foreach($check_array as $check_array_value)
            {
                $val=array(
                    'zone_id'=>0
                );
                DB::table('district')->where('id','=',$check_array_value)->update($val);
            }
        if ($zone->delete()) {
            return redirect('/admin/zone/')->with('success', 'Deleted Successfully');
        }
    }
}