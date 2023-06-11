<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use File;

use Illuminate\Http\Request;
use App\Models\SubSegment;


class SubSegmentController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.SubSegment.view');
    }

    public function create()
    {
        return view('admin.SubSegment.create');
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

    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('Segment_image'), $imageName);

       $SubSegment=New SubSegment();
       $SubSegment->cat_id = $request->cat_id;
       $SubSegment->subcat_id = $request->subcat_id;
       $SubSegment->megacategory_id= $request->megacategory;
       $SubSegment->Segment_id= $request->Segment;
       $SubSegment->SegmentSub= $request->SubSegment;
       $SubSegment->image = $imageName;
       
        if( $SubSegment->save())
        {
            return redirect('/admin/SubSegment/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/SubSegment/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show()
    {
        //
    }

    
    public function edit(SubSegment $SubSegment)
    {
        return view('admin.SubSegment.update',compact('SubSegment'));
    }

    
    public function update(Request $request, SubSegment $SubSegment )
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

        $SubSegment->cat_id = $request->cat_id;
        $SubSegment->subcat_id = $request->subcat_id;
        $SubSegment->megacategory_id= $request->megacategory;
        $SubSegment->Segment_id= $request->Segment;
        $SubSegment->SegmentSub= $request->SubSegment;
       $SubSegment->image = $imageName;

        if( $SubSegment->save())
        {
            return redirect('/admin/SubSegment/'. $SubSegment->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/SubSegment/'. $SubSegment->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

  
    public function destroy(SubSegment $SubSegment)
    {
        $previous_path=public_path().'/Segment_image/'. $SubSegment->image;
        if( $SubSegment->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ( $SubSegment->delete()) {
            return redirect('/admin/SubSegment')->with('success', 'Deleted Successfully');
        }
    }
}
