<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Http\Request;
use App\Models\Segment;

class SegmentController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.Segment.view');
    }

    public function create()
    {
        return view('admin.Segment.create');
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

    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('Segment_image'), $imageName);

       $Segment=New Segment();
       $Segment->cat_id = $request->cat_id;
       $Segment->subcat_id = $request->subcat_id;
       $Segment->megacategory_id= $request->megacategory;
       $Segment->Segment= $request->Segment;
       $Segment->image = $imageName;
       
        if($Segment->save())
        {
            return redirect('/admin/Segment/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/Segment/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show()
    {
        //
    }

    
    public function edit(Segment $Segment)
    {
        return view('admin.Segment.update',compact('Segment'));
    }

    
    public function update(Request $request, Segment $Segment )
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

        $Segment->cat_id = $request->cat_id;
        $Segment->subcat_id = $request->subcat_id;
        $Segment->megacategory_id= $request->megacategory;
        $Segment->Segment= $request->Segment;
       $Segment->image = $imageName;

        if($Segment->save())
        {
            return redirect('/admin/Segment/'.$Segment->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/Segment/'.$Segment->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

  
    public function destroy(Segment $Segment)
    {
        $previous_path=public_path().'/Segment_image/'.$Segment->image;
        if($Segment->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ($Segment->delete()) {
            return redirect('/admin/Segment/')->with('success', 'Deleted Successfully');
        }
    }
}
