<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Profile;
use App\Models\Job;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Location;
use App\Models\JobApplied;
use App\Models\JobType;
use App\Models\VendorsCandidates;

class JobsApiController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return $jobs;
    }
    

    public function store(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $messages = [
            'jobid.unique'          => 'This Job ID is already in use, please choose a different Job ID.',
        ];
            $request->validate([
                'title'                 => 'required|string|max:100',
                'jobid'                 => 'required|unique:jobs|alpha_dash|max:50',
                'job_type'              => 'required',
                'department'            => 'required',
                'designation'           => 'required',
                'location_id'           => 'required',
                'no_of_vacancy'         => 'required|numeric',
                'job_expiry_date'       => 'required',
                'location_preference'   => 'required',  
                'minimum_qualification' => 'required',
                'gender_preference'     => 'required',
                'description'           => 'required|min:100',
                'attachment'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],$messages);
            
            $data = new Job;
            if($request->hasFile('attachment'))
            {
                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $attachment_path = Storage::putFileAs('public/job-cover/'.$request->jobid, $request->file('attachment'), $name);
                $data->attachment= $attachment_path;
            }
                $data->user_id          =       59;
          
            $data->jobtype_id                    = $request->job_type;
            $data->department_id                 = $request->department;
            $data->jobid                         = $request->jobid;
            $data->designation_id                = $request->designation;
            $data->description                   = $request->description;
            $data->title                         = $request->title;
            $data->location_id                   = $request->location_id;
            $data->salary                        = $request->salary;
            $data->no_of_vacancy                 = $request->no_of_vacancy;
            $data->minimum_exp_req               = $request->minimum_exp_req;
            $data->minimum_qualification         = $request->minimum_qualification;
            $data->location_preference           = $request->location_preference;
            $data->gender_preference             = $request->gender_preference;
            $data->job_expiry_date               = $request->job_expiry_date;
            $data->save();
            
        return $data;
    }else{
        return 'Unauthorised';
    }
    }

    public function getJobType(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $job_type=JobType::orderBy('id','DESC')->get();
        return $job_type;
    }else{
        return 'Unauthorised';
    }
    }
    public function getDepartment(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $departments = Department::orderBy('id','DESC')->get();
        return $departments;
        }else{
            return 'Unauthorised';
        }
    }
    public function getDesignation(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $designation=Designation::orderBy('id','DESC')->get();
        return $designation;
    }else{
        return 'Unauthorised';
    }
    }
    public function getLocation(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $locations = Location::orderBy('id','DESC')->get();
        return $locations;
    }else{
        return 'Unauthorised';
    }
    }
    public function getCandidates(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $candidates_id =  User::whereHas('roles', function($q){
            $q->where('title', 'Candidate');
        })->pluck('id'); 
        $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
        $users['profile']= Profile::whereIn('user_id',$candidates_id)->select('*')->get();            
        $users['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
        $users['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
        $users['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','status','email','phone')->get();   

        $vendors_candidate_id = VendorsCandidates::pluck('id');
        $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
        $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
        $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('*')->get();
        $candidates[0]=$users;
        $candidates[1]=$VendorsCandidates;
        return $candidates;
    }else{
        return 'Unauthorised';
    }
    }
    public function getJobs(Request $request){
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
            $jobs = Job::get();
        return($jobs);
        } else{
            return 'Unauthorised';
        }
    }
    public function getAppliedCandidates(Request $request){
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
    if($request->key == $key){
        $jobid=$request->job_id;
        $candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');    
        $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
        $applied_candidates['profile']= Profile::whereIn('user_id',$candidates_id)->select('*')->get();
        $applied_candidates['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
        $applied_candidates['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
        $applied_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_candidates['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','email','phone')->get();
       
        $vendors_candidate_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');
        $applied_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
        $applied_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
        $applied_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('*')->get();
        return($applied_candidates);
        } else{
            return 'Unauthorised';
        }
    }
    public function getShortlistCandidates(Request $request){
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
    if($request->key == $key){
        $jobid=$request->job_id;
        $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
        $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
        $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('*')->get();
        $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
        $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();


        $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
        $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
        $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('*')->get();
        return($shortlist_candidates);
        } else{
            return 'Unauthorised';
        }
    }
   
       
}
