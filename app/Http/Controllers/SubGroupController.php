<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use File;

use Illuminate\Http\Request;
use App\Models\SubGroup;

class SubGroupController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.SubGroup.view');
    }

    public function create()
    {
        return view('admin.SubGroup.create');
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
    public function get_Group(Request $request)
    {
        $get_Group=$request->category;
        $row=DB::table('groups')->where('SegmentSub_id','=', $get_Group)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->Group."</option>";            
        
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

      $SubGroup=New SubGroup();
      $SubGroup->cat_id = $request->cat_id;
      $SubGroup->subcat_id = $request->subcat_id;
      $SubGroup->megacategory_id= $request->megacategory;
      $SubGroup->Segment_id= $request->Segment;
      $SubGroup->SegmentSub_id	= $request->SubSegment;
      $SubGroup->Group_id= $request->Group;
      $SubGroup->Sub_Group= $request->SubGroup;
      $SubGroup->image = $imageName;
       
        if($SubGroup->save())
        {
            return redirect('/admin/SubGroup/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/SubGroup/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show()
    {
        //
    }

    
    public function edit(SubGroup $SubGroup)
    {
        return view('admin.SubGroup.update',compact('SubSegment'));
    }

    
    public function update(Request $request,  SubGroup $SubGroup )
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

       $SubGroup->cat_id = $request->cat_id;
       $SubGroup->subcat_id = $request->subcat_id;
       $SubGroup->megacategory_id= $request->megacategory;
       $SubGroup->Segment_id= $request->Segment;
       $SubGroup->SegmentSub= $request->SubSegment;
      $SubGroup->image = $imageName;

        if($SubGroup->save())
        {
            return redirect('/admin/SubGroup/'.$SubGroup->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/SubGroup/'.$SubGroup->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

  
    public function destroy(SubGroup $SubGroup)
    {
        $previous_path=public_path().'/Segment_image/'.$SubGroup->image;
        if($SubGroup->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ($SubGroup->delete()) {
            return redirect('/admin/SubGroup')->with('success', 'Deleted Successfully');
        }
    }
}
