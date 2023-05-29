<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kfupm_user;
use Mail;
use Auth;
use App\User;
use Illuminate\Support\Facades\Storage;

class KfupmController extends Controller
{
    public function register(){
        return view('kfupmregister',compact());
    }

    public function filter_kfupm_users(Request $request){
       
        $messages = [
            'job_registration_date.required'         => 'Please Select a Date for filter',
        ];
        $request->validate([
            'job_registration_date'                      =>  'required',
        ],$messages);
        $posting_date=$request->created_at;

        
        if(Auth::user()->hasRole('Admin')){

        $users= kfupm_user::whereDate('created_at',$posting_date)->select('name','email','phone','major','created_at')->get();
        
    }  
        return view('admin.kfupm-users.index', compact('users'));
    }
    
    
    public function saveData(Request $request){

        $this->validate($request,[
            'email'                 =>   'required|unique:kfupm_users',
            'name'                  =>   'required',
            'mobile'                 =>   'required',   
            'student'               =>   'required',
            'national_id'           =>   'required',
            'major'                 =>   'required',
            'degree'                =>   'required',
            'university'            =>   'required',  
            'cv'                    =>  'required|mimes:docx,doc,pdf|max:4000',
            'certificate'           =>  'required|mimes:docx,doc,pdf|max:4000',
            ]);
            
        $kfupm = new kfupm_user;
        $kfupm->name  =  $request->name;
        $kfupm->email  =  $request->email;
        $kfupm->phone  =  "+966".''.$request->mobile;
        $kfupm->student  =  $request->student;
        $kfupm->national_id  =  $request->national_id;
        $kfupm->major  =  $request->major;
        $kfupm->degree  =  $request->degree;
        $kfupm->university  =  $request->university;

        if($request->degree == 'others'){
            $kfupm->degree = $request->otherDegree;
        }

        if($request->student == 'others'){
            $kfupm->student = $request->otherStudent;
        }

        
        if($request->has('cv')){
            $cv = $request->file('cv');
            $renameCv = rand(100,1000000000).'.'.$cv->getClientOriginalExtension();
            $cvDestination = public_path('/KFUPM/CV');
            $cv->move($cvDestination,$renameCv);
            // save data 
            $kfupm->cv = $renameCv;
        }
        
        if($request->has('certificate')){
            $certificate = $request->file('certificate');
            $renameCertificate = rand(100,1000000000).'.'.$certificate->getClientOriginalExtension();
            $certificateDestination = public_path('/KFUPM/Certificate');
            $certificate->move($certificateDestination,$renameCertificate);
            // save data 
            $kfupm->certificate = $renameCertificate;
        }
        
        if($kfupm->save()){
            return redirect('kfupmregister')->with('status','Record Created Successfully.');
        }
    }
}