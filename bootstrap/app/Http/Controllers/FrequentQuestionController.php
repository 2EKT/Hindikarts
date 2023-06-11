<?php

namespace App\Http\Controllers;

use App\Models\FrequentQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class FrequentQuestionController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.frequentquestion.view');
    }

   
    public function create()
    {
        return view('admin.frequentquestion.create');
    }

  
    public function store(Request $request)
    {
        $frequentquestion=New FrequentQuestion;
        $frequentquestion->question = $request->question;
        $frequentquestion->answer = $request->answer;
       
        if($frequentquestion->save())
        {
            return redirect('/admin/frequent-questions/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/frequent-questions/create')->with('error', 'Something Went Wrong');
        }
    }
    public function show(FrequentQuestion $frequentQuestion)
    {
        //
    }

    
    public function edit(FrequentQuestion $frequentQuestion)
    {
        return view('admin.frequentquestion.update',compact('frequentQuestion'));
    }

   
    public function update(Request $request, FrequentQuestion $frequentQuestion)
    {
        $frequentQuestion->question = $request->question;
        $frequentQuestion->answer = $request->answer;
       
        if($frequentQuestion->save())
        {
            return redirect('/admin/frequent-questions/'.$frequentQuestion->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/frequent-questions/'.$frequentQuestion->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(FrequentQuestion $frequentQuestion)
    {
        if ($frequentQuestion->delete()) {
            return redirect('/admin/frequent-questions/')->with('success', 'Deleted Successfully');
        }
    }
}