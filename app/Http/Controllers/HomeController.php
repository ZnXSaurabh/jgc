<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Job;
use App\Models\Location;
use App\Models\JobType;
use App\Models\JobApplied;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $total_job = count(Job::orderBy('id','DESC')->where('status',1)->where('approved_by','!=',NULL)->get());
        $jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        return view('home',compact('jobs','total_job','locations','departments','jobtypes','recent_jobs'));
    }
    public function browseJobs()
    {   
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $total_job = count(Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->get());
        $jobs= Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        return view('browse-jobs',compact('jobs','total_job','locations','departments','jobtypes','recent_jobs'));
    }
    public function show($id)
    {
        if(Auth::user()){
            $applied_job = JobApplied::where('job_id',$id)->where('candidate_id', Auth::user()->id)->first();
        }else{
            $applied_job=NULL;
        }
        // $job = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->where('id', $id)->where('status', 1)->first();
        $job = Job::where('id', $id)->where('status', 1)->where('job_expiry_date' ,'>', date('Y-m-d'))->first();
        $similar_jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->where('id','!=',$id)->where('status', 1)->limit(5)->get();
     
        return view('job-detail',compact('job','applied_job','similar_jobs'));
    }
    public function searchLocation(Request $request)
    {   
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $total_job = count(Job::orderBy('id','DESC')->where('status',1)->where('approved_by','!=',NULL)->get());
        $jobs  = Job::where('location_id', $request->location)->Where('status',1)->where('approved_by','!=',NULL)->paginate(7);
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        return view('home',compact('jobs','total_job','recent_jobs','locations','jobtypes','departments'));
    }
    public function searchLocationBrowse(Request $request)
    {   
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $total_job = count(Job::orderBy('id','DESC')->where('location_id','=',$request->location)->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->get());
        $jobs  = Job::where('location_id','=',$request->location)->where('job_expiry_date' ,'>', date('Y-m-d'))->Where('status',1)->where('approved_by','!=',NULL)->paginate(7);
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        return view('browse-jobs',compact('jobs','total_job','recent_jobs','locations','jobtypes','departments'));
    }
    public function filterHomeJobs(Request $request)
    { 
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $jobs = Job::where(function ($query) use ($request)  {
            $query->orWhere('jobType_id', $request->job_type)->orWhere('department_id',$request->department)->where('minimum_exp_req' ,'<=' ,$request->experienceFrom)->where('minimum_exp_req' ,'>=' ,$request->experienceTo)->orWhere('minimum_qualification', $request->qualification);
        })->orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->paginate(7);
        $total_job = count(Job::where(function ($query) use ($request){
            $query->orWhere('jobType_id', $request->job_type)->orWhere('department_id',$request->department)->where('minimum_exp_req' ,'<=' ,$request->experienceFrom)->where('minimum_exp_req' ,'>=' ,$request->experienceTo)->orWhere('minimum_qualification', $request->qualification);
        })->orderBy('id','DESC')->where('status','=',1)->get());
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        
        return view('home',compact('jobs','total_job','departments','recent_jobs','locations','jobtypes'));
    }
    public function filterJobs(Request $request)
    {  
        $recent_jobs = Job::orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by','!=',NULL)->paginate(7);
        $jobs = Job::where(function ($query) use ($request)  {
            $query->orWhere('jobType_id', $request->job_type)->orWhere('department_id',$request->department)->where('minimum_exp_req' ,'<=' ,$request->experienceFrom)->where('minimum_exp_req' ,'>=' ,$request->experienceTo)->orWhere('minimum_qualification', $request->qualification);
        })->orderBy('id','DESC')->where('status','=',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->paginate(7);
        $total_job = count(Job::where(function ($query) use ($request)  {
            $query->orWhere('jobType_id', $request->job_type)->orWhere('department_id',$request->department)->where('minimum_exp_req' ,'<=' ,$request->experienceFrom)->where('minimum_exp_req' ,'>=' ,$request->experienceTo)->orWhere('minimum_qualification', $request->qualification);
        })->orderBy('id','DESC')->where('status','=',1)->get());
        $locations  = Location::all();
        $jobtypes  = JobType::where('status',1)->get();
        $departments  = Department::where('status','=','1')->get();
        return view('browse-jobs',compact('jobs','recent_jobs','total_job','departments','locations','jobtypes'));
    }
}
