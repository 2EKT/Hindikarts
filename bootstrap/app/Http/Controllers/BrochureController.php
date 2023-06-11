<?php

namespace App\Http\Controllers;

use App\Models\Brochure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class BrochureController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.documents.view');
    }

   
    public function create()
    {
        return view('admin.documents.create');
    }

  
    public function store(Request $request)
    {
        $brochure=New Brochure;
        $given_document = $request->file_name;
        $extention = $given_document->getClientOriginalExtension();
        $document_name = time().'.'.$extention;
        $given_document->move(public_path('document'), $document_name);

        $brochure->name = $request->name;
        $brochure->file_name = $document_name;
        
        if($brochure->save())
        {
            return redirect('/admin/documents/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/documents/create')->with('error', 'Something Went Wrong');
        }
    }
    public function show()
    {
        //
    }

    
    public function edit(Brochure $document)
    {
        return view('admin.documents.update',compact('document'));
    }

   
    public function update(Request $request, Brochure $document)
    {
        $document->name = $request->name;

        if(!empty($request->file_name)){
            if(!empty($document->file_name)){
                $previous_path = public_path().'/document/'.$document->file_name;
                
                if(File::exists($previous_path)){
                    unlink($previous_path);
                }

                $given_document = $request->file_name;
                $extention = $given_document->getClientOriginalExtension();
                $document_name = time().'.'.$extention;
                $given_document->move(public_path('document'), $document_name);
                $document->file_name = $document_name;
            }
        }
        
        if($document->save())
        {
            return redirect('/admin/documents/'.$document->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/documents/'.$document->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Brochure $document)
    {
        if ($document->delete()) {
            if(!empty($document->file_name)){
                $previous_path = public_path().'/document/'.$document->file_name;
                
                if(File::exists($previous_path)){
                    unlink($previous_path);
                }
            }
            return redirect('/admin/documents/')->with('success', 'Deleted Successfully');
        }
    }
}