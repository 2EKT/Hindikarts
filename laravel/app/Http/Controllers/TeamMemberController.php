<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.teammember.view');
    }

    public function create()
    {
        return view('admin.teammember.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('banner_image'), $imageName);

        $teammember=New TeamMember;
        $teammember->image = $imageName;
        $teammember->name = $request->name;
        $teammember->designation = $request->designation;
       
        if($teammember->save())
        {
            return redirect('/admin/teammember/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/teammember/create')->with('error', 'Something Went Wrong');
        }
    }

    
    public function show(TeamMember $teamMember)
    {
        //
    }

    
    public function edit($id)
    {
        return view('admin.teammember.update',compact('id'));
    }

    
    public function update(Request $request, TeamMember $teamMember)
    {
        if($request->hasFile('image'))
           {
                $validated = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('banner_image'), $imageName);
               
                $previous_path=public_path().'/banner_image/'.$request->previous_image;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $imageName=$request->previous_image;
           }
        
            $val=array(
                'image'=>$imageName,
                'name'=>$request->name,
                'designation'=>$request->designation
            );

           $affected = DB::table('team_members')
              ->where('id', $request->id)
              ->update($val);

        if($affected==true)
        {
            return redirect('/admin/teammember/edit/'.$request->id)->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/teammember/edit/'.$request->id)->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Request $request)
    {
        $previous_path=public_path().'/banner_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('team_members')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/teammember/')->with('success', 'Deleted Successfully');
        }
    }
}