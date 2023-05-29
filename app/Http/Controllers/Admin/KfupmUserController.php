<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kfupm_user; 

class KfupmUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * Scope a query to only include the last n days records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function index()
    {   
        
        $KfupmUsers = kfupm_user::all();
        
        $users = kfupm_user::select('major')->distinct()->get();
        
        $qualifications = kfupm_user::select('degree')->distinct()->get();
    
        return view('admin.kfupm-users.index',compact('KfupmUsers', 'users', 'qualifications'));
    }
    
      public function filter_kfupm_users(Request $request){
       
        $messages = [
            'job_registration_date.required'         => 'Please Select a Date for filter',
        ];
        $request->validate([
            'job_registration_date'                      =>  'required',
        ],$messages);
        $posting_date =  $request->job_registration_date;
        
        // var_dump($posting_date);
        if(Auth::user()->hasRole('Admin')){

        $KfupmUsers= kfupm_user::where('created_at',$posting_date)->select('name','email','phone','major','created_at')->get();
       
    }  
    
    
        // $KfupmUsers = kfupm_user::all();
    
        return view('admin.kfupm-users.index',compact('KfupmUsers'));
        
        //  return view('admin.kfupm-users.index', compact('Kfupm_users'));
    }
    
    public function show($id)
    {
        $KfupmUser= kfupm_user::where('id','=',$id)->first();
        return view('admin.kfupm-users.show',compact('KfupmUser'));
    }
   
    
}
