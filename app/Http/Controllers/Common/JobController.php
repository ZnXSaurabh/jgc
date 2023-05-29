<?php
namespace App\Http\Controllers\Common;

use DB;
use Mail;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Profile;
use App\Models\Location;
use App\Models\Proposal;
use App\Models\Education;
use App\Models\Department;
use App\Models\Dxperience;
use App\Models\JobApplied;
use App\Models\Experience;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Mail\JobApplyConfirm;
use App\Models\VendorsCandidates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

// use Storage;
class JobController extends Controller
{
    public function index()
    {   
        abort_unless(\Gate::allows('job_access'), 403);
        if (Auth()->user()->hasRole('Admin') || Auth()->user()->hasRole('Super Admin')) {
            $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->get();
        }elseif(Auth::user()->hasRole('Vendor')){
            $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->get();
        } elseif(Auth::user()->hasRole('HR')){
            $jobs = Job::where('user_id','=',Auth::user()->id)->where('job_expiry_date' ,'>', date('Y-m-d'))->orderBy('id','DESC')->get();
        } else {
            $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'>', date('Y-m-d'))->get(); 
        }
        
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('job_create'), 403);
        $locations    = Location::all();
        $departments  = Department::where('status','=','1')->get();
        $designations = Designation::where('status','=','1')->get();
        $experinces   = Experience::where('status','=','1')->get();
        $job_types    = JobType::where('status','=','1')->get();
        return view('admin.jobs.create',compact('experinces','departments','designations','job_types','locations'));
    }

    public function store(Request $request)
    {  
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
        $data->user_id              =       Auth::user()->id;
        if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin')){
            $data->approved_by      =       Auth::user()->id;
            $data->status           =       1;
            $data->posting_date     =       date('y-m-d');
        }elseif(Auth::user()->hasRole('HR Manager')){
            $data->approved_by      =       Auth::user()->id;
            $data->status           =       1;
            $data->posting_date     =       date('y-m-d');
        }
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
        return redirect()->route('common.jobs.index')->with('message', 'Job create successfully');
    }

    public function edit($id)
    {       
        abort_unless(\Gate::allows('job_edit'), 403);
        $locations = Location::all();
        $job = Job::find($id);
        $departments=Department::where('status','=','1')->get();
        $designations=Designation::where('status','=','1')->get();
        $experinces=Experience::where('status','=','1')->get();
        $job_types=JobType::where('status','=','1')->get();
        return view('admin.jobs.edit', compact('job','experinces','departments','designations','job_types','locations'));
    }

    public function update(Request $request, $id)
    {    $messages = [
            'jobid.unique'          => 'This Job ID is already in use, please choose a different Job ID.',
         ];
        $this->validate($request, [
            'title'                 => 'required|max:250',
            'jobid'                 => 'required|alpha_dash|max:100|unique:jobs,jobid,'.$id,
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
        $job = Job::findOrFail($id);
        if($request->hasFile('attachment')) {
            
            $file = $request->file('attachment');
            $name = $file->getClientOriginalName();
            $attachment_path = Storage::putFile('public/job-cover/'.$request->jobid, $request->file('attachment'));
            $job->attachment= $attachment_path;
        }
        $job->jobtype_id               = $request->job_type;
        $job->department_id             = $request->department;
        $job->designation_id            = $request->designation;
        $job->description               = $request->description;
        $job->title                     = $request->title;
        $job->location_id               = $request->location_id;
        $job->salary                    = $request->salary;
        $job->jobid                     = $request->jobid;
        $job->no_of_vacancy             = $request->no_of_vacancy;
        $job->minimum_exp_req           = $request->minimum_exp_req;
        $job->minimum_qualification     = $request->minimum_qualification;
        $job->location_preference       = $request->location_preference;
        $job->gender_preference         = $request->gender_preference;
        $job->status                    = $request->status;
        $job->job_expiry_date           = $request->job_expiry_date;
        $job->save();

        return redirect()->route('common.jobs.index')->with('message', 'Job Updated successfully');
    }

    public function show($jobid)
    {
        abort_unless(\Gate::allows('job_show'), 403);
        $job = Job::find($jobid);
        if(Auth::user()->hasRole('Vendor')){
            $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
            $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
            $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
            $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
            $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
            $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();

            $candidatess_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id')->toArray();
            $id =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
            $candidates_id[] = array_intersect($candidatess_id,$id);
            $applied_jobs['candidate_exp'] = Experience::whereIn('vendors_user_id',$candidates_id)->select('level','start_year','end_year')->get();
            $applied_jobs['candidate_edu'] = Education::whereIn('vendors_user_id',$candidates_id)->select('level','course','percentage')->get();
            $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
            $applied_jobs['candidate_detail'] = VendorsCandidates::whereIn('id',$candidates_id)->select('id','name','email','phone','dob')->get();

        }else{
        $candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');    
        $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
        $applied_jobs['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob')->get();
        $applied_jobs['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
        $applied_jobs['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
        $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','email','phone')->get();
       

        $vendors_candidate_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');
        $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
        $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
        $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
        

        $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
        $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
        $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
        $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
        $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
        $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();
        // $not_applied_candidates    =   User::where('created_by', Auth::user()->id)->whereNotIn('id',$applied_candidates)->get();]
    }
        $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
        $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
        $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('dob')->get();
        $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
        $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();


        $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
        $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
        $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('id','name','email','phone','dob')->get();

        return view('admin.jobs.show', compact('job','applied_jobs','shortlist_candidates','not_applied_candidates'));
  
    }

    public function destroy(Job $job)
    {
        abort_unless(\Gate::allows('job_delete'), 403);
        $job->delete();
        return redirect()->back()->with('message', 'Job deleted successfully');
    }
    
    public function AppliedJob($id)
    {   
        if(Auth::user()){
            if(empty(Auth::user()->id)){
                return redirect()->route('home');
            }
        }
        $user = User::findOrFail(Auth::user()->id);
        if($user->profile->country=='' || $user->profile->city=='' || $user->profile->state=='' ){
            return redirect()->route('common.candidate.edit',Auth::user()->id)->with('message','Please Complete Your Profile');
        }else{
            $data = new JobApplied; 
            $data->candidate_id=Auth::user()->id;
            $data->job_id=$id;
            $data->applied_date=Carbon::now()->toDateTimeString();
        }
        $job_id = Job::where('id',$id)->pluck('jobid')->first();
        Mail::to($user->email)->later(now()->addSeconds(5), new JobApplyConfirm($user, $job_id));
        if($data->save())
        {
            return $user;
        }
    }
    public function  job_apply_by_vendor(Request $request,$id)
    {
        $n=count($request->user_id);
        for($i=0;$i<$n;$i++)
        {   
            $data = new JobApplied; 
            $data->vendors_candidate_id=$request->user_id[$i];
            $data->job_id=$id;
            $data->applied_by= Auth::user()->id;
            $data->applied_date=Carbon::now()->toDateTimeString();
            $data->save();
        }
        
        return redirect()->back()->with('message', 'Applied Successfully!');
    }

    public function ShortlistJob($id)
    {  
        JobApplied::where('id','=',$id)->update(['status'=>'1']);
        return redirect()->back()->with('message', 'Candidate Shortlisted Successfully');
       
    }
    
    public function UnShortlistJob($id)
    {  
        JobApplied::where('id','=',$id)->update(['status'=>'0']);
        return redirect()->back()->with('message', 'Candidate Removed From Shortlist Successfully');
       
    }
    // public function ViewProfile($id)
    // {  
    //    $JobApplied= JobApplied::find($id);
    //    $user_id=$JobApplied['candidate_id'];
    //    $experiences =   Experience::where('profile_id','=',$user_id)->get();
    //    $educations  =   Education::where('profile_id','=',$user_id)->get();
    //    $profile=Profile::where('user_id','=',$user_id)->get();
    //    return view('admin.jobs.view-profile',compact('profile','JobApplied','educations','experiences'));
    // }
    
    public function approved_jobs()
    {   
        $jobs = Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>=', date('Y-m-d'))->where('status',1)->orderBy('id','DESC')->get();
        return view('admin.jobs.index', compact('jobs'));
    }
    public function unapproved_jobs()
    {   
        abort_unless(\Gate::allows('job_access'), 403);

        $jobs = Job::where('approved_by','=',NULL)->where('job_expiry_date' ,'>=', date('Y-m-d'))->orderBy('id','DESC')->get();
        return view('admin.jobs.index', compact('jobs'));
    }
   public function show_expired_job()
   {


    if (Auth()->user()->hasRole('Admin') || Auth()->user()->hasRole('Super Admin')) {
        $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'<', date('Y-m-d'))->get();
    }elseif(Auth::user()->hasRole('Vendor')){
        $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'<', date('Y-m-d'))->get();
    } elseif(Auth::user()->hasRole('HR')){
        $jobs = Job::where('user_id','=',Auth::user()->id)->where('job_expiry_date' ,'<', date('Y-m-d'))->orderBy('id','DESC')->get();
    } else {
        $jobs = Job::orderBy('id','DESC')->where('job_expiry_date' ,'<', date('Y-m-d'))->get(); 
    }
    
    return view('admin.jobs.index', compact('jobs'));
   }
   
   public function applied_filter_by_age(Request $request){
    $job = Job::find($request->jobid);
    $jobid=$request->jobid;
    $age=$request->age;
    $jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
    $messages = [
        'age.required'         => 'Please enter age first',
    ];
    $request->validate([
        'age'                      =>  'required',
    ],$messages);

    if(Auth::user()->hasRole('Vendor')){


        $candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');     
        $vendors['candidate_age']=VendorsCandidates::select('id','dob')->where('created_by', Auth::user()->id)->whereIn('id',$candidates_id)->get();

        foreach($vendors['candidate_age'] as $key => $user_age){
            if(Carbon::parse($vendors['candidate_age'][$key]->dob)->age >= $request->age){
                $vendors_candidate_id[] = $vendors['candidate_age'][$key]['id'];
            }
        }
        if($vendors_candidate_id !=NULL){
             $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
             $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
             $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
             $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
        }

        
    }
    else{
    $candidatess_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');    
    $users['candidate_age'] = Profile::select('user_id','dob')->whereIn('user_id',$candidatess_id)->get();
    foreach($users['candidate_age'] as $key => $user_age){
        if(Carbon::parse($users['candidate_age'][$key]->dob)->age >= $request->age){
            dd('done');
            $candidates_id[] = $users['candidate_age'][$key]['user_id'];
        }
    }
  
    if($candidates_id != NULL){
    $applied_jobs['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob','id')->get();
    foreach($applied_jobs['profile'] as $key => $profiles_id){
        $profile_id[]=$applied_jobs['profile'][$key]->id;
    }
    $applied_jobs['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
    $applied_jobs['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
    $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
    $applied_jobs['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','email','phone')->get();
}
    

    $candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');     
    $vendors['candidate_age']=VendorsCandidates::select('id','dob')->whereIn('id',$candidates_id)->get();

    foreach($vendors['candidate_age'] as $key => $user_age){
        if(Carbon::parse($vendors['candidate_age'][$key]->dob)->age >= $request->age){
            $vendors_candidate_id[] = $vendors['candidate_age'][$key]['id'];
        }
    }
    if($vendors_candidate_id !=NULL){
         $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
         $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
         $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
         $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
    }
    }
    
    $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
    $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
    $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
    $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
    $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
    $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();
        

        $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
        $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
        $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('dob')->get();
        $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
        $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();


        $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
        $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
        $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
        $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
        $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('id','name','email','phone','dob')->get();
        return view('admin.jobs.show', compact('job','applied_jobs','shortlist_candidates','age','not_applied_candidates'));
        
}
public function applied_filter_by_exp(Request $request){
    $job = Job::find($request->jobid);
    $messages = [
        'exp.required'         => 'Please Select Experience for filter',
    ];
    $request->validate([
        'exp'                      =>  'required',
    ],$messages);

    $jobid=$request->jobid;
    $exp     =    $request->exp;

    if(Auth::user()->hasRole('Vendor')){

        $vendors_candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');

        $users['vendors_candidate_exp']   =  Experience::select('vendors_user_id','start_year','end_year')->whereIn('vendors_user_id',$vendors_candidates_id)->get();
        foreach($users['vendors_candidate_exp'] as $key => $start_year){
            $totalDuration=0;
        foreach(json_decode($users['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
           {
            $startTime = Carbon::parse($start_year);

            $endTime = Carbon::parse(json_decode($users['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);

            $totalDuration += $startTime->diffInMonths($endTime);
             }
            $total_exp[$key]= round($totalDuration/12,1);
            if($total_exp[$key] >= $request->exp){
                $vendors_candidate_id[] = $users['vendors_candidate_exp'][$key]['vendors_user_id'];
               }
            }
            
            $id = VendorsCandidates::where('created_by',Auth::user()->id)->pluck('id')->toArray();
            $vendorss_candidate_id =  array_intersect($id,$vendors_candidate_id);
        if($vendorss_candidate_id !=NULL){
        $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','start_year','end_year')->get();
        $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','course','percentage')->get();
        $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendorss_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendorss_candidate_id)->select('id','name','email','phone','dob')->get();
        }

    }
    else{

                                                $candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');
                                                $profiles_id    =   Profile::whereIn('user_id',$candidates_id)->pluck('id');
                                                $users['candidate_exp']   =  Experience::select('profile_id','start_year','end_year')->whereIn('profile_id',$profiles_id)->get();
                                                foreach($users['candidate_exp'] as $key => $start_year){
                                                    $totalDuration=0;
                                                foreach(json_decode($users['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                   {
                                                    $startTime = Carbon::parse($start_year);

                                                    $endTime = Carbon::parse(json_decode($users['candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                     }
                                                    $total_exp[$key]= round($totalDuration/12,1);
                                                    if($total_exp[$key] >= $request->exp){
                                                        $profiless_id[] = $users['candidate_exp'][$key]['profile_id'];
                                                       }
                                                    }
                                                    
                                                    
                                                    if($profiless_id !=NULL){
                                                        $candidate_id = Profile::whereIn('id',$profiless_id)->pluck('user_id');
                                                    $applied_jobs['candidate_exp'] = Experience::whereIn('profile_id',$profiless_id)->select('level','start_year','end_year')->get();
                                                    $applied_jobs['candidate_edu'] = Education::whereIn('profile_id',$profiless_id)->select('level','course','percentage')->get();
                                                    $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
                                                    $applied_jobs['candidate_detail'] = User::whereIn('id',$candidate_id)->select('id','name','email','phone')->get();
                                                
                                                    }

                                                $vendors_candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');

                                                $users['vendors_candidate_exp']   =  Experience::select('vendors_user_id','start_year','end_year')->whereIn('vendors_user_id',$vendors_candidates_id)->get();
                                                foreach($users['vendors_candidate_exp'] as $key => $start_year){
                                                    $totalDuration=0;
                                                foreach(json_decode($users['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                   {
                                                    $startTime = Carbon::parse($start_year);

                                                    $endTime = Carbon::parse(json_decode($users['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                     }
                                                    $total_exp[$key]= round($totalDuration/12,1);
                                                    if($total_exp[$key] >= $request->exp){
                                                        $vendors_candidate_id[] = $users['vendors_candidate_exp'][$key]['vendors_user_id'];
                                                       }
                                                    }
                                                if($vendors_candidate_id !=NULL){
                                                $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
                                                $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
                                                $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
                                                $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
                                                }

                                            }

                                            $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
                                            $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
                                            $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
                                            $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
                                            $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
                                            $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();
                                                
                                        
                                                $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
                                                $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
                                                $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('dob')->get();
                                                $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
                                                $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
                                                $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
                                                $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();
                                        
                                        
                                                $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
                                                $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
                                                $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
                                                $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
                                                $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('id','name','email','phone','dob')->get();
                                                return view('admin.jobs.show', compact('job','applied_jobs','exp','shortlist_candidates','not_applied_candidates'));
                                            }
    public function shortlist_filter_by_age(Request $request){
    $job = Job::find($request->jobid);
    $jobid=$request->jobid;
    $age=$request->age;
    $jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
    $messages = [
        'age.required'         => 'Please enter age first',
    ];
    $request->validate([
        'age'                      =>  'required',
    ],$messages);

    $candidatesss_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');    
    $profilee_id = Profile::whereIn('user_id',$candidatesss_id)->pluck('id');

    $applied_jobs['profile']= Profile::whereIn('user_id',$candidatesss_id)->select('dob')->get();
    $applied_jobs['candidate_exp'] = Experience::whereIn('profile_id',$profilee_id)->select('level','start_year','end_year')->get();
    $applied_jobs['candidate_edu'] = Education::whereIn('profile_id',$profilee_id)->select('level','course','percentage')->get();
    $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidatesss_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
    $applied_jobs['candidate_detail'] = User::whereIn('id',$candidatesss_id)->select('id','name','email','phone')->get();
    
    $vendorss_candidate_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');
    $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','start_year','end_year')->get();
    $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','course','percentage')->get();
    $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendorss_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
    $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendorss_candidate_id)->select('id','name','email','phone','dob')->get();
    
    
    $candidate_id = JobApplied::where('job_id',$jobid)->where('status',1)->where('candidate_id','!=',NULL)->pluck('candidate_id');   
    $users['candidate_age'] = Profile::select('user_id','dob')->whereIn('user_id',$candidate_id)->get();
    foreach($users['candidate_age'] as $key => $user_age){
        if(Carbon::parse($users['candidate_age'][$key]->dob)->age >= $request->age){
            $candidates_id[] = $users['candidate_age'][$key]['user_id'];
        }
    }
    
    if($candidates_id != NULL){
    $shortlist_candidates['profiles']= Profile::whereIn('user_id',$candidates_id)->select('dob','id')->get();
   
    foreach($shortlist_candidates['profiles'] as $key => $profiles_id){
        $profile_id[]=$shortlist_candidates['profiles'][$key]->id;
    }
    
   
    $shortlist_candidates['profile']= Profile::whereIn('id',$profile_id)->select('dob')->get();
    
    $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
    $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
    $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
    $shortlist_candidates['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','email','phone')->get();
}
    $candidates_id = JobApplied::where('job_id',$jobid)->where('status',1)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');     
    $vendors['candidate_age']=VendorsCandidates::select('id','dob')->whereIn('id',$candidates_id)->get();

    foreach($vendors['candidate_age'] as $key => $user_age){
        if(Carbon::parse($vendors['candidate_age'][$key]->dob)->age >= $request->age){
            $vendors_candidate_id[] = $vendors['candidate_age'][$key]['id'];
        }
    }
    if($vendors_candidate_id !=NULL){
         $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
         $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
         $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
         $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
    }
    $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
    $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
    $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
    $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
    $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
    $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();
        return view('admin.jobs.show', compact('job','applied_jobs','age','shortlist_candidates','not_applied_candidates'));
                                                    
    }
    public function shortlist_filter_by_exp(Request $request){
        
        $job = Job::find($request->jobid);
        $messages = [
            'exp.required'         => 'Please Select Experience for filter',
        ];
        $request->validate([
            'exp'                      =>  'required',
        ],$messages);
    
        $jobid=$request->jobid;
        $exp     =    $request->exp;


        $candidatesss_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('candidate_id','!=',NULL)->pluck('candidate_id');    
        $profilee_id = Profile::whereIn('user_id',$candidatesss_id)->pluck('id');
    
        $applied_jobs['profile']= Profile::whereIn('user_id',$candidatesss_id)->select('dob')->get();
        $applied_jobs['candidate_exp'] = Experience::whereIn('profile_id',$profilee_id)->select('level','start_year','end_year')->get();
        $applied_jobs['candidate_edu'] = Education::whereIn('profile_id',$profilee_id)->select('level','course','percentage')->get();
        $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidatesss_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['candidate_detail'] = User::whereIn('id',$candidatesss_id)->select('id','name','email','phone')->get();
        
        $vendorss_candidate_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');
        $applied_jobs['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','start_year','end_year')->get();
        $applied_jobs['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','course','percentage')->get();
        $applied_jobs['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendorss_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendorss_candidate_id)->select('id','name','email','phone','dob')->get();

    
                                                    $candidates_id = JobApplied::where('job_id',$jobid)->where('status',1)->where('candidate_id','!=',NULL)->pluck('candidate_id');
                                                    $profiles_id    =   Profile::whereIn('user_id',$candidates_id)->pluck('id');
                                                    $users['candidate_exp']   =  Experience::select('profile_id','start_year','end_year')->whereIn('profile_id',$profiles_id)->get();
                                                    foreach($users['candidate_exp'] as $key => $start_year){
                                                        $totalDuration=0;
                                                    foreach(json_decode($users['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                       {
                                                        $startTime = Carbon::parse($start_year);
    
                                                        $endTime = Carbon::parse(json_decode($users['candidate_exp'][$key]['end_year'], true)[$expkey]);
    
                                                        $totalDuration += $startTime->diffInMonths($endTime);
                                                         }
                                                        $total_exp[$key]= round($totalDuration/12,1);
                                                        if($total_exp[$key] >= $request->exp){
                                                            $profiless_id[] = $users['candidate_exp'][$key]['profile_id'];
                                                           }
                                                        }
                                                        if($profiless_id !=NULL){
                                                            $candidate_id = Profile::whereIn('id',$profiless_id)->pluck('user_id');
                                                        $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$profiless_id)->select('level','start_year','end_year')->get();
                                                        $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$profiless_id)->select('level','course','percentage')->get();
                                                        $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$candidate_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
                                                        $shortlist_candidates['candidate_detail'] = User::whereIn('id',$candidate_id)->select('id','name','email','phone')->get();
                                                    
                                                        }
   
                                                    $vendors_candidates_id = JobApplied::where('job_id',$jobid)->where('status',1)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id');
    
                                                    $users['vendors_candidate_exp']   =  Experience::select('vendors_user_id','start_year','end_year')->whereIn('vendors_user_id',$vendors_candidates_id)->get();
                                                    foreach($users['vendors_candidate_exp'] as $key => $start_year){
                                                        $totalDuration=0;
                                                    foreach(json_decode($users['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                       {
                                                        $startTime = Carbon::parse($start_year);
    
                                                        $endTime = Carbon::parse(json_decode($users['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);
    
                                                        $totalDuration += $startTime->diffInMonths($endTime);
                                                         }
                                                        $total_exp[$key]= round($totalDuration/12,1);
                                                        if($total_exp[$key] >= $request->exp){
                                                            $vendors_candidate_id[] = $users['vendors_candidate_exp'][$key]['vendors_user_id'];
                                                           }
                                                        }
                                                    if($vendors_candidate_id !=NULL){
                                                    $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
                                                    $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
                                                    $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
                                                    $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
                                                    }
                                                    $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
                                                    $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
                                                    $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
                                                    $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','start_year','end_year')->get();
                                                    $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$not_applied_candidates_id)->select('level','course','percentage')->get();
                                                    $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$not_applied_candidates_id)->select('id','name','email','phone','dob')->get();
                                                    
                                            
                                                   
                                                    return view('admin.jobs.show', compact('job','applied_jobs','exp','shortlist_candidates','not_applied_candidates'));
                                                }    
 public function notapplied_filter_by_age(Request $request){
    $job = Job::find($request->jobid);
    $jobid=$request->jobid;
    $age=$request->age;
    $jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
    $messages = [
        'age.required'         => 'Please enter age first',
    ];
    $request->validate([
        'age'                      =>  'required',
    ],$messages);
         $vendor_users_id    =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
         $applied_candidates =   JobApplied::whereIn('vendors_candidate_id', $vendor_users_id)->where('job_id','=',$jobid)->pluck('vendors_candidate_id')->toArray();      
         $not_applied_candidates_id = Array_diff($vendor_users_id,$applied_candidates);
         $vendors['candidate_age']=VendorsCandidates::select('id','dob')->where('id',$not_applied_candidates_id)->get();
        foreach($vendors['candidate_age'] as $key => $user_age){
            if(Carbon::parse($vendors['candidate_age'][$key]->dob)->age >= $request->age){
                $vendors_candidate_id[] = $vendors['candidate_age'][$key]['id'];
            }
        }
        if($vendors_candidate_id !=NULL){
             $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
             $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
             $not_applied_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendors_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
             $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','phone','dob')->get();
        }   
        $candidatess_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id')->toArray();
        $id =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
        $candidates_id[] = array_intersect($candidatess_id,$id);
        $applied_jobs['candidate_exp'] = Experience::whereIn('vendors_user_id',$candidates_id)->select('level','start_year','end_year')->get();
        $applied_jobs['candidate_edu'] = Education::whereIn('vendors_user_id',$candidates_id)->select('level','course','percentage')->get();
        $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
        $applied_jobs['candidate_detail'] = VendorsCandidates::whereIn('id',$candidates_id)->select('id','name','email','phone','dob')->get();
        
            $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
            $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
            $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('dob')->get();
            $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
            $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
            $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
            $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();
    
    
            $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
            $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
            $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
            $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
            $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('id','name','email','phone','dob')->get();
            return view('admin.jobs.show', compact('job','applied_jobs','age','shortlist_candidates','not_applied_candidates'));
        }
                                                                              
        public function notapplied_filter_by_exp(Request $request){
            $job = Job::find($request->jobid);
            $messages = [
                'exp.required'         => 'Please Select Experience for filter',
            ];
            $request->validate([
                'exp'                      =>  'required',
            ],$messages);
        
            $jobid=$request->jobid;
            $exp     =    $request->exp;
        
            
        
                $vendors_candidates_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id')->toArray();
               
                $users['vendors_candidate_exp']   =  Experience::select('vendors_user_id','start_year','end_year')->whereIn('vendors_user_id',$vendors_candidates_id)->get();
                foreach($users['vendors_candidate_exp'] as $key => $start_year){
                    $totalDuration=0;
                foreach(json_decode($users['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                   {
                    $startTime = Carbon::parse($start_year);
        
                    $endTime = Carbon::parse(json_decode($users['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);
        
                    $totalDuration += $startTime->diffInMonths($endTime);
                     }
                    $total_exp[$key]= round($totalDuration/12,1);
                    if($total_exp[$key] >= $request->exp){
                        $vendors_candidate_id[] = $users['vendors_candidate_exp'][$key]['vendors_user_id'];
                       }
                    }
                    $id = VendorsCandidates::where('created_by',Auth::user()->id)->pluck('id')->toArray();
                    $vend_candidate_id =  Array_diff( $vendors_candidate_id,$id);
                    $vendorss_candidate_id = array_intersect($vend_candidate_id,$vendors_candidate_id);
                if($vendorss_candidate_id !=NULL){
                $not_applied_candidates['candidate_exp'] = Experience::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','start_year','end_year')->get();
                $not_applied_candidates['candidate_edu'] = Education::whereIn('vendors_user_id',$vendorss_candidate_id)->select('level','course','percentage')->get();
                $not_applied_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$vendorss_candidate_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
                $not_applied_candidates['candidate_detail'] = VendorsCandidates::whereIn('id',$vendorss_candidate_id)->select('id','name','email','phone','dob')->get();
                }


                $candidatess_id = JobApplied::where('job_id',$jobid)->where('status',0)->where('vendors_candidate_id','!=',NULL)->pluck('vendors_candidate_id')->toArray();
            $id =   VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
            $candidates_id[] = array_intersect($candidatess_id,$id);
            $applied_jobs['candidate_exp'] = Experience::whereIn('vendors_user_id',$candidates_id)->select('level','start_year','end_year')->get();
            $applied_jobs['candidate_edu'] = Education::whereIn('vendors_user_id',$candidates_id)->select('level','course','percentage')->get();
            $applied_jobs['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
            $applied_jobs['candidate_detail'] = VendorsCandidates::whereIn('id',$candidates_id)->select('id','name','email','phone','dob')->get();
        
            $shortlist_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('candidate_id');
            $shortlist_profile_id = Profile::whereIn('user_id',$shortlist_candidates_id)->pluck('id');
            $shortlist_candidates['profile']= Profile::whereIn('user_id',$shortlist_candidates_id)->select('dob')->get();
            $shortlist_candidates['candidate_exp'] = Experience::whereIn('profile_id',$shortlist_profile_id)->select('level','start_year','end_year')->get();
            $shortlist_candidates['candidate_edu'] = Education::whereIn('profile_id',$shortlist_profile_id)->select('level','course','percentage')->get();
            $shortlist_candidates['appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('candidate_id',$shortlist_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
            $shortlist_candidates['candidate_detail'] = User::whereIn('id',$shortlist_candidates_id)->select('id','name','email','phone')->get();
    
    
            $shortlist_vendors_candidates_id   =   JobApplied::where('job_id',$jobid)->where('status','1')->pluck('vendors_candidate_id');
            $shortlist_candidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','start_year','end_year')->get();
            $shortlist_candidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$shortlist_vendors_candidates_id)->select('level','course','percentage')->get();
            $shortlist_candidates['vendors_appliedcandidates'] = JobApplied::where('job_id','=',$jobid)->whereIn('vendors_candidate_id',$shortlist_vendors_candidates_id)->where('status','=','1')->select('id','applied_by','applied_date')->get();
            $shortlist_candidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$shortlist_vendors_candidates_id)->select('id','name','email','phone','dob')->get();
            return view('admin.jobs.show', compact('job','applied_jobs','shortlist_candidates','exp','not_applied_candidates'));
        
           
        }
}
