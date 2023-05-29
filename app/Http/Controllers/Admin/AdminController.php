<?php
namespace App\Http\Controllers\Admin;

use DB;
use Mail;
use Auth;
use App\User;
use App\Role;
use App\UserToken;
use App\Models\Job;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Department;
use App\Models\JobApplied;
use Illuminate\Support\Str;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\VendorsCandidates;
use App\Mail\CandidateRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
// Add by shubham
use App\Models\kfupm_user;


class AdminController extends Controller
{
	public function __construct()
    { 
        $this->middleware('auth');
    }

    public function index()
    {    
        $total_job                  = Job::where('approved_by' ,'!=',NULL)->where('status',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->count();
        // dd($total_job);
        $total_vendor               = Vendor::where('status',1)->count();
        $total_applied_job          = JobApplied::where('status',1)->count();
        $total_department           = Department::where('status',1)->count();
        $total_designation          = Designation::where('status',1)->count();
        $total_unapproved_job       = Job::where('approved_by','=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',0)->count();
        $total_candidate            = User::where('created_by','=',NULL)->where('status',1)->count();
        $total_approved_job         = Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->count();        
        $total_candidate_by_vendor  = VendorsCandidates::where('created_by','=',Auth::user()->id)->where('status',1)->count();
        $recent_jobs                = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->where('approved_by' ,'!=',NULL)->where('status',1)->get();
        // Add by shubham 
        $total_kfupmUser            = kfupm_user ::all();

        //Add total_kfupmUser in campact by shubham only in admin check
        if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin')){
            return view('admin.dashboard',compact('total_job','total_candidate','total_applied_job','total_vendor','total_department','total_designation','recent_jobs','total_approved_job','total_unapproved_job','total_kfupmUser'));
        }elseif(Auth::user()->hasRole('Vendor')){
            return view('admin.vendors.dashboard',compact('total_job','total_candidate_by_vendor','total_applied_job','recent_jobs'));
        }elseif(Auth::user()->hasRole('HR')){
            $total_job                  = Job::where('user_id',Auth::user()->id)->where('job_expiry_date' ,'>', date('Y-m-d'))->count();
            $recent_jobs                = Job::orderBy('id','DESC')->where('approved_by' ,'!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->where('user_id',Auth::user()->id)->get();
            return view('admin.hr.dashboard',compact('total_job','total_candidate','total_applied_job','total_vendor','total_department','total_designation','recent_jobs'));
        }elseif(Auth::user()->hasRole('HR Manager')){
            $total_hr                  = Job::count();
            return view('admin.hr-managers.dashboard',compact('total_job','total_candidate','total_applied_job','total_vendor','total_department','total_approved_job','recent_jobs','total_unapproved_job','total_designation'));
        }
    }
}