<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use File;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.Group.view');
    }

    public function create()
    {
        return view('admin.Group.create');
    }

    public function get_subcategory(Request $request)
    {
        $category=$request->category;
        $row=DB::table('subcategories')->where('cat_id','=',$category)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->subcategory."</option>";            
            
        }
    }
    public function get_megacategory(Request $request)
    {
        $Subcategory=$request->category;
        $row=DB::table('megacategories')->where('subcat_id','=',$Subcategory)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->megacategory."</option>";            
            
        }
    }
     public function get_Segment(Request $request)
    {
        $get_Segment=$request->category;
        $row=DB::table('segments')->where('megacategory_id','=',$get_Segment)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->Segment."</option>";            
            
        }
    } 
    
    public function get_SubSegment(Request $request)
    {
        $get_SubSegment=$request->category;
        $row=DB::table('sub_segments')->where('Segment_id','=', $get_SubSegment)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->SegmentSub."</option>";            
        
        }
            // echo "<option value=2>SubSegmnet</option>";            
    }

    
    
    public function store(Request $request)
    {
        // dd($request->all());
        // exit();
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('Segment_image'), $imageName);

      $Group=New Group();
      $Group->cat_id = $request->cat_id;
      $Group->subcat_id = $request->subcat_id;
      $Group->megacategory_id= $request->megacategory;
      $Group->Segment_id= $request->Segment;
      $Group->SegmentSub_id	= $request->SubSegment;
      $Group->Group= $request->Group;
      $Group->image = $imageName;
       
        if($Group->save())
        {
            return redirect('/admin/Group/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/Group/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show()
    {
        //
    }

    
    public function edit(Group $Group)
    {
        return view('admin.Group.update',compact('Group'));
    }

    
    public function update(Request $request,  Group $Group )
    {
        if($request->hasFile('image'))
        {
             $validated = $request->validate([
                 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
             ]);
             $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
             request()->image->move(public_path('Segment_image'), $imageName);
            
             $previous_path=public_path().'/Segment_image/'.$request->previous_image;
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

       $Group->cat_id = $request->cat_id;
       $Group->subcat_id = $request->subcat_id;
       $Group->megacategory_id= $request->megacategory;
       $Group->Segment_id= $request->Segment;
       $Group->	SegmentSub_id= $request->SubSegment;
       $Group->Group= $request->Group;
      $Group->image = $imageName;

        if($Group->save())
        {
            return redirect('/admin/Group/'.$Group->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/Group/'.$Group->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

  
    public function destroy(Group $Group)
    {
        $previous_path=public_path().'/Segment_image/'.$Group->image;
        if($Group->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ($Group->delete()) {
            return redirect('/admin/Group/')->with('success', 'Deleted Successfully');
        }
    }
}
