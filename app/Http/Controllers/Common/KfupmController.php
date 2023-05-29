<?php

namespace App\Http\Controllers\Common;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kfupm_user;
use App\Exports\kfupmExport;
use Mail;
use Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KfupmController extends Controller
{
      /**
     * Scope a query to only include the last n days records
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

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

        $KfupmUsers= DB::table('kfupm_users')->whereDate('created_at', $posting_date)->get();
       
       $users = kfupm_user::select('major')->distinct()->get();
       
       $qualifications = kfupm_user::select('degree')->distinct()->get();
    }  
        
    
        // $KfupmUsers = kfupm_user::all();
    
        return view('admin.kfupm-users.index',compact('KfupmUsers','users','qualifications'));
        
        //  return view('admin.kfupm-users.index', compact('Kfupm_users'));
    }
    
    public function filter_by_major(Request $request){
        //$jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
        $messages = [
            'major.required'         => 'Please Select Major for filter',
        ];
        $request->validate([
            'major'                      =>  'required',
        ],$messages);
        $major     =    $request->major;
         //var_dump($major);
        if(Auth::user()->hasRole('Admin')){

        $KfupmUsers= DB::table('kfupm_users')->where('major', $major)->get();
       
}

        return view('admin.kfupm-users.index',compact('KfupmUsers'));
}

        public function filter_by_degree(Request $request){
        //$jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
        $messages = [
            'degree.required'         => 'Please Select Degree for filter',
        ];
        $request->validate([
            'degree'                      =>  'required',
        ],$messages);
        
        $degree     =    $request->degree;
        
        if(Auth::user()->hasRole('Admin')){

        $KfupmUsers= DB::table('kfupm_users')->where('degree', $degree)->get();
        
       
}

        return view('admin.kfupm-users.index',compact('KfupmUsers'));
}
        public function export(){
        return Excel::download(new kfupm_userExport, 'kfupm_users.xlsx');
     }
}