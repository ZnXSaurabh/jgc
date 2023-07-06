<?php
namespace App\Http\Controllers\Common;
use DB;
use Mail;
use Auth;
use App\User;
use App\UserToken;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\Profile;
use App\Models\Country;
use App\Models\Education;
use App\Models\Experience;
use App\Models\EducationalLevel;
use App\Models\VendorsCandidates;
use App\Models\JobApplied;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CandidateRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('candidate_access'), 403);
        if(Auth::user()->hasRole('Super Admin')||Auth::user()->hasRole('Admin')||Auth::user()->hasRole('HR')||Auth::user()->hasRole('HR Manager')){
            $candidates_id =  User::whereHas('roles', function($q){
                $q->where('title', 'Candidate');
            })->pluck('id'); 
            $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
            $users['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob')->get();            
            $users['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
            $users['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
            $users['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','status','email','phone')->get();   

        $vendors_candidate_id = VendorsCandidates::pluck('id');
        $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
        $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
        $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','status','phone','dob')->get();
    }
        // elseif(Auth::user()->hasRole('Admin')){
        //     $candidates_id =  User::where('created_by','=',Auth::user()->id)->whereHas('roles', function($q){
        //         $q->where('title', 'Candidate');
        //     })->pluck('id'); 
        //     $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
        //     $users['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob')->get();            
        //     // $users['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
        //     $users['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
        //     $users['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','status','email','phone')->get(); 
        // }
        elseif(Auth::user()->hasRole('Vendor')){
            $candidates_id =  VendorsCandidates::where('created_by','=',Auth::user()->id)->pluck('id');   
            $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$candidates_id)->select('level','start_year','end_year')->get();
            $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$candidates_id)->select('level','course','percentage')->get();
            $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$candidates_id)->select('id','name','status','email','phone','dob')->get(); 
           
        }
       $jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
       $exp = null;
       $age = null;

    //    foreach(json_decode($VendorsCandidates['vendors_candidate_exp'][0]['start_year'], true) as $expkey => $start_year){
    //     dd($start_year);
    //    }
        return view('admin.candidate.index', compact('users','jobs','exp','age','VendorsCandidates'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $EducationalLevels = EducationalLevel::where('status','1')->get();
        return view('admin.candidate.create', compact('countries','EducationalLevels'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if(Auth::user()->hasRole('Vendor')){


            $messages = [
                'name.required'         => 'Fullname field is required.',
                'name.max'              => 'Fullname field must be less than 191 characters',
                'phone.required'        => 'Mobile Number is required.',
                'phone.numeric'         => 'Mobile Number must be numeric.',
                'phone.min'             => 'Mobile Number must be of 10 characters.',
                'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
                'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
                'email.required'        => 'Email field is required.',
            ];
            $request->validate([
                'name'                  =>  'max:191',
                'email'                 =>  'email|unique:vendors_candidates',
                'phone'                 =>  'numeric|min:10|unique:vendors_candidates',
                'dob'                   =>  'date',
                'city'                  =>  'max:191',
                'state'                 =>  'max:191',
                'country'               =>  'max:191',
                'pincode'               =>  'nullable|max:191',
                'address'               =>  'nullable|max:500',
                'level'                 =>  'max:191',
                'course'                =>  'max:191',
                'university'            =>  'max:500',
                'about'                 =>  'nullable|max:2000|string',
                'resume'                =>  'mimes:docx,doc,pdf|max:2048',
                'profile_pic'           =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            ],$messages);

            $user = VendorsCandidates::create([
                'name'      =>  $request->name,
                'email'     =>  $request->email,
                'phone'     =>  $request->phone,
                'created_by'=>  Auth::user()->id,
                'address'   =>  $request->address,
                'country'   =>  $request->country,
                'city'      =>  $request->city,
                'state'     =>  $request->state,
                'zip_code'  =>  $request->pincode,
                'about'     =>  $request->about,
                'dob'       =>  $request->dob,
                'gender'    =>  $request->gender,
            ]);


            Education::create([
                'vendors_user_id'    =>  $user->id,
                'level'              =>  json_encode($request->level),
                'course'             =>  json_encode($request->course),
                'university'         =>  json_encode($request->university),
                'percentage'         =>  json_encode($request->percentage),
                'start_year'         =>  json_encode($request->education_start_year),
                'end_year'           =>  json_encode($request->education_end_year),
            ]);
            Experience::create([
                'vendors_user_id'    =>  $user->id,
                'level'              =>  json_encode($request->experiencelevel),
                'designation'        =>  json_encode($request->designation),
                'department'         =>  json_encode($request->department),
                'organisation'       =>  json_encode($request->organisation),
                'start_year'         =>  json_encode($request->experience_start_year),
                'end_year'           =>  json_encode($request->experience_end_year),
            ]);
            
            if($request->hasFile('resume')) {
                $file = $request->file('resume');
                $name = $file->getClientOriginalName();
                $resume_path = Storage::putFile('public/resume/'.$user->id, $request->file('resume'));
                VendorsCandidates::where('id',$user->id)->update(['resume'=> $name]);
            }
            if($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $name = $file->getClientOriginalName();
                $pic_path = Storage::putFile('public/profile_pic/'.$user->id, $request->file('profile_pic'));
                VendorsCandidates::where('id',$user->id)->update(['profile_pic'=> $name]);
                
            }
        }else{
            $messages = [
                'name.required'         => 'Fullname field is required.',
                'name.max'              => 'Fullname field must be less than 191 characters',
                'phone.required'        => 'Mobile Number is required.',
                'phone.numeric'         => 'Mobile Number must be numeric.',
                'phone.min'             => 'Mobile Number must be of 10 characters.',
                'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
                'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
                'email.required'        => 'Email field is required.',
            ];
            $request->validate([
                'name'                  =>  'max:191',
                'email'                 =>  'email|unique:users',
                'phone'                 =>  'numeric|min:10|unique:users',
                'dob'                   =>  'date',
                'city'                  =>  'max:191',
                'state'                 =>  'max:191',
                'country'               =>  'max:191',
                'pincode'               =>  'nullable|max:191',
                'address'               =>  'nullable|max:500',
                'level'                 =>  'max:191',
                'course'                =>  'max:191',
                'university'            =>  'max:500',
                'about'                 =>  'nullable|max:2000|string',
                'resume'                =>  'mimes:docx,doc,pdf|max:2048',
                'profile_pic'           =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            ],$messages);
        $user  = User::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'phone'     =>  $request->phone,
            'created_by'=>  Auth::user()->id,
        ]);
        $profile = Profile::create([
            'user_id'   =>  $user->id,
            'address'   =>  $request->address,
            'country'   =>  $request->country,
            'city'      =>  $request->city,
            'state'     =>  $request->state,
            'zip_code'  =>  $request->pincode,
            'about'     =>  $request->about,
            'dob'       =>  $request->dob,
            'gender'    =>  $request->gender,
        ]);
        Education::create([
            'profile_id'         =>  $profile->id,
            'level'              =>  json_encode($request->level),
            'course'             =>  json_encode($request->course),
            'university'         =>  json_encode($request->university),
            'percentage'         =>  json_encode($request->percentage),
            'start_year'         =>  json_encode($request->education_start_year),
            'end_year'           =>  json_encode($request->education_end_year),
        ]);
        Experience::create([
            'profile_id'         =>  $profile->id,
            'level'              =>  json_encode($request->experiencelevel),
            'designation'        =>  json_encode($request->designation),
            'department'         =>  json_encode($request->department),
            'organisation'       =>  json_encode($request->organisation),
            'start_year'         =>  json_encode($request->experience_start_year),
            'end_year'           =>  json_encode($request->experience_end_year),
        ]);
        $user->roles()->sync(3);
        if($request->hasFile('resume')) {
            $file = $request->file('resume');
            $name = $file->getClientOriginalName();
            $resume_path = Storage::putFile('public/resume/'.$user->id, $request->file('resume'));
            Profile::where('user_id',$user->id)->update(['resume'=> $name]);
        }
        if($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $name = $file->getClientOriginalName();
            $pic_path = Storage::putFile('public/profile_pic/'.$user->id, $request->file('profile_pic'));
            Profile::where('user_id',$user->id)->update(['profile_pic'=> $name]);
        }
        //Send token
        UserToken::create([
            'user_id' => $user->id,
            'token'   => Str::random(50)
        ]);
        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
            'email' =>  $user->email,
        ]));

        Mail::to($user->email)->later(now()->addSeconds(5), new CandidateRegistration($user, $url));

        }
        return $user;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showProfile()
    {   
        $candidate      =   User::findOrFail(Auth::user()->id);
        $experiences    =   Experience::where('profile_id','=',$candidate->profile->id)->first();
        $educations     =   Education::where('profile_id','=',$candidate->profile->id)->first();
        $profile        =   Profile::where('user_id', Auth::user()->id)->first();
        $count          =   Profile::where('user_id', Auth::user()->id)->count();

        $maximumPoints  = 100;
        if ($profile->address != "" && $profile->profile_pic != "") {
            $hasAddress = 50;
        } elseif ($profile->address != "") {
            $hasAddress = 45;
        } else {
            $hasAddress = 0;
        }
        
        if ($experiences !== null && $experiences->level != "") {
            $hasExperiencesLevel = 25;
        } else {
            $hasExperiencesLevel = 0;
        }
        
        if ($educations !== null && $educations->level != "") {
            $hasEducationsLevel = 25;
        } else {
            $hasEducationsLevel = 0;
        }
        
        $profilePercentage = ($hasAddress+$hasExperiencesLevel+$hasExperiencesLevel)*$maximumPoints/100;
        
        return view('candidate-profile',compact('profile','experiences','educations', 'profilePercentage'));
    }

    public function show($id)
    {  
        if(Auth::user()->hasRole('Vendor')){
            $candidate      =   VendorsCandidates::findOrFail($id);
            $experience     =   Experience::where('vendors_user_id','=',$candidate->id)->first();
            $education      =   Education::where('vendors_user_id','=',$candidate->id)->first();
            return view('admin.vendors-candidate.show',compact('candidate','experience','education'));
        }else{
            $candidate      =   User::findOrFail($id);
            $experience     =   Experience::where('profile_id','=',$candidate->profile->id)->first();
            $education      =   Education::where('profile_id','=',$candidate->profile->id)->first();
            $profile        =   Profile::where('user_id', $id)->first();
            return view('admin.candidate.show',compact('profile','experience','education'));
        }
    }
    public function vendors_candidates_show($id)
    {  
            $candidate      =   VendorsCandidates::findOrFail($id);
            $experience     =   Experience::where('vendors_user_id','=',$candidate->id)->first();
            $education      =   Education::where('vendors_user_id','=',$candidate->id)->first();
            return view('admin.vendors-candidate.show',compact('candidate','experience','education'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function candidateEdit($id)
    {   
        $countries          =   Country::all();
        $EducationalLevels = EducationalLevel::where('status',1)->get();
        $candidate          =   VendorsCandidates::findOrFail($id);
        $educations         =   Education::where('vendors_user_id',$candidate->id)->first();
        $experiences        =   Experience::where('vendors_user_id',$candidate->id)->first();

        return view('admin.vendors-candidate.edit', compact('candidate','countries','educations','experiences','EducationalLevels'));

    }
    public function edit($id)
    {   
        $countries          =   Country::all();
        $EducationalLevels = EducationalLevel::where('status',1)->get();
        $candidate          =   User::findOrFail($id);
        $educations         =   Education::where('profile_id',$candidate->profile->id)->first();
        $experiences        =   Experience::where('profile_id',$candidate->profile->id)->first();

        // dd($EducationalLevels);

        if(Auth::user()->hasRole('Candidate')){
            return view('update-profile', compact('candidate','countries','educations','experiences','EducationalLevels'));
        }else{
            return view('admin.candidate.edit', compact('candidate','countries','educations','experiences','EducationalLevels'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function candidateUpdate(Request $request, $id)
    {   
        $messages = [
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.min'             => 'Mobile Number must be of 10 characters.',
            'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];
        $request->validate([
            'name'                      =>  'max:191',
            'email'                     =>  'email|unique:vendors_candidates,email,'.$id,
            'phone'                     =>  'numeric|min:10|unique:vendors_candidates,phone,'.$id,
            'city'                      =>  'max:191',
            'state'                     =>  'max:191',
            'country'                   =>  'max:191',
            'pincode'                   =>  'nullable|max:191',
            'address'                   =>  'nullable|max:500',
            'level'                     =>  'max:191',
            'course'                    =>  'max:191',
            'university'                =>  'max:500',
            'educations.*.education_start_year'    =>  'date|before:education_end_year',
            'educations.*.education_end_year'      =>  'date|after:education_start_year',
            'experiences.*.experience_start_year'   =>  'date|before:experience_end_year',
            'experiences.*.experience_end_year'     =>  'date|after:experience_start_year',
            'about'                     =>  'nullable|max:2000|string',
            'resume'                    =>  'nullable|mimes:docx,doc,pdf|max:4000',
            'profile_pic'               =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ],$messages);
        $candidate  = VendorsCandidates::find($id);
        $candidate->name      =  $request->name;
        if($candidate->email != $request->email){
            $candidate->email    =  $request->email;
        }
        $candidate->phone    = $request->phone;
        $candidate->address  = $request->address;
        $candidate->country  = $request->country;
        $candidate->city     = $request->city;
        $candidate->state    = $request->state;
        $candidate->zip_code = $request->pincode;
        $candidate->about    = $request->about;
        $candidate->dob      = $request->dob;
        $candidate->gender   = $request->gender;
        $candidate->status   =  1;
        $candidate->save();

        Education::where('vendors_user_id',$candidate->id)->update([
            'vendors_user_id'    =>  $candidate->id,
            'level'         =>  json_encode($request->level),
            'course'        =>  json_encode($request->course),
            'university'    =>  json_encode($request->university),
            'percentage'    =>  json_encode($request->percentage),
            'start_year'    =>  json_encode($request->education_start_year),
            'end_year'      =>  json_encode($request->education_end_year),
        ]);
        Experience::where('vendors_user_id',$candidate->id)->update([
            'vendors_user_id'    =>  $candidate->id,
            'level'         =>  json_encode($request->experiencelevel),
            'designation'   =>  json_encode($request->designation),
            'department'    =>  json_encode($request->department),
            'organisation'  =>  json_encode($request->organisation),
            'start_year'    =>  json_encode($request->experience_start_year),
            'end_year'      =>  json_encode($request->experience_end_year),
        ]);
        if($request->hasFile('resume')) {
            $file = $request->file('resume');
            $name = $file->getClientOriginalName();
            // unlink(storage_path('app/'.$profile->resume));
            $resume_path = Storage::putFileAs('public/resume/'.$candidate->id, $request->file('resume'), $name);
            VendorsCandidates::where('id',$user->id)->update(['resume'=> $name]);
        }
        if($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $name = $file->getClientOriginalName();
            //unlink(storage_path('app/'.$profile->profile_pic));
            $pic_path = Storage::putFileAs('public/profile_pic/'.$candidate->id, $request->file('profile_pic'), $name);
            VendorsCandidates::where('id',$user->id)->update(['profile_pic'=> $name]);
        }
       
        return $candidate;
      
    }
    public function update(Request $request, $id)
    {   
        $messages = [
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.min'             => 'Mobile Number must be of 10 characters.',
            'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];
        $request->validate([
            'name'                      =>  'max:191',
            'email'                     =>  'email|unique:users,email,'.$id,
            'phone'                     =>  'numeric|min:10|unique:users,phone,'.$id,
            'city'                      =>  'max:191',
            'state'                     =>  'max:191',
            'country'                   =>  'max:191',
            'pincode'                   =>  'nullable|max:191',
            'address'                   =>  'nullable|max:500',
            'level'                     =>  'max:191',
            'course'                    =>  'max:191',
            'university'                =>  'max:500',
            'educations.*.education_start_year'    =>  'date|before:education_end_year',
            'educations.*.education_end_year'      =>  'date|after:education_start_year',
            'experiences.*.experience_start_year'   =>  'date|before:experience_end_year',
            'experiences.*.experience_end_year'     =>  'date|after:experience_start_year',
            'about'                     =>  'nullable|max:2000|string',
            'resume'                    =>  'nullable|mimes:docx,doc,pdf|max:4000',
            'profile_pic'               =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ],$messages);

            $candidate  = User::find($id);
        
            $candidate->name      =  $request->name;
    
            if($candidate->email != $request->email){
                $candidate->email    =  $request->email;
            }
            $candidate->phone    = $request->phone;
            $candidate->status   =  1;
            $candidate->save();
       
        $candidate  = User::find($id);
        
        $candidate->name      =  $request->name;

        if($candidate->email != $request->email){
            $candidate->email    =  $request->email;
        }
        $candidate->phone    = $request->phone;
        $candidate->status   =  1;
        $candidate->save();
        // $candidate->update([
        //     'name'      =>  $request->name,
        //     'email'     =>  $request->email,
        //     'phone'     =>  $request->phone,
        //     'status'    =>  $request->status,
        // ]);
      
        $profile = Profile::where('user_id',$id)->first();
        $profile->update([
            'user_id'   =>  $candidate->id,
            'address'   =>  $request->address,
            'country'   =>  $request->country,
            'city'      =>  $request->city,
            'state'     =>  $request->state,
            'zip_code'  =>  $request->pincode,
            'about'     =>  $request->about,
            'dob'       =>  $request->dob,
            'gender'    =>  $request->gender,
        ]);
        Education::where('profile_id',$profile->id)->update([
            'profile_id'    =>  $profile->id,
            'level'         =>  json_encode($request->level),
            'course'        =>  json_encode($request->course),
            'university'    =>  json_encode($request->university),
            'percentage'    =>  json_encode($request->percentage),
            'start_year'    =>  json_encode($request->education_start_year),
            'end_year'      =>  json_encode($request->education_end_year),
        ]);
        Experience::where('profile_id',$profile->id)->update([
            'profile_id'    =>  $profile->id,
            'level'         =>  json_encode($request->experiencelevel),
            'designation'   =>  json_encode($request->designation),
            'department'    =>  json_encode($request->department),
            'organisation'  =>  json_encode($request->organisation),
            'start_year'    =>  json_encode($request->experience_start_year),
            'end_year'      =>  json_encode($request->experience_end_year),
        ]);
        $candidate->roles()->sync(3);
        if($request->hasFile('resume')) {
            $file = $request->file('resume');
            $name = $file->getClientOriginalName();
            // unlink(storage_path('app/'.$profile->resume));
            $resume_path = Storage::putFileAs('public/resume/'.$candidate->id, $request->file('resume'), $name);
            Profile::where('user_id',$candidate->id)->update(['resume'=> $name]);
        }
        if($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $name = $file->getClientOriginalName();
            //unlink(storage_path('app/'.$profile->profile_pic));
            $pic_path = Storage::putFileAs('public/profile_pic/'.$candidate->id, $request->file('profile_pic'), $name);
            Profile::where('user_id',$candidate->id)->update(['profile_pic'=> $name]);
        }
        return $candidate;
    
        
    }
    public function update_education(Request $request)
    {  
        $request->validate([
            'level'                        =>  'required',
            'university'                   =>  'required',
            'course'                       =>  'required',
            'percentage'                   =>  'required',
            'education_start_year'         =>  'required',
            'education_end_year'           =>  'required',
        ]);

        $id =  Auth::user()->id; 
        $request->validate([
            'level'                        =>  'required',
            'university'                   =>  'required',
            'course'                       =>  'required',
            'percentage'                   =>  'required',
            'education_start_year'         =>  'required',
            'education_end_year'           =>  'required',
        ]);
        Education::create([
            'profile_id'         =>  $id,
            'level'              =>  $request->level,
            'course'             =>  $request->course,
            'university'         =>  $request->university,
            'percentage'         =>  $request->percentage,
            'start_year'         =>  $request->education_start_year,
            'end_year'           =>  $request->education_end_year,
        ]);
        $educations =   Education::where('profile_id','=',Auth::user()->id)->get();
        return json_encode($educations);

    }
    public function update_experience(Request $request)
    {
        $request->validate([
            'level'                         =>  'required',
            'designation'                   =>  'required',
            'department'                    =>  'required',
            'organisation'                  =>  'required',
            'experience_start_year'         =>  'required',
            'experience_end_year'           =>  'required',
        ]);
        $id =  Auth::user()->id; 
        Experience::create([
            'profile_id'         =>  $id,
            'level'              =>  $request->level,
            'designation'        =>  $request->designation,
            'department'         =>  $request->department,
            'organisation'       =>  $request->organisation,
            'start_year'         =>  $request->experience_start_year,
            'end_year'           =>  $request->experience_end_year,
        ]);
        $experiences =   Experience::where('profile_id','=',Auth::user()->id)->get();
        return json_encode($experiences);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function candidateDestroy($id)
    { 
        Education::where('vendors_user_id',$id)->delete();
        Experience::where('vendors_user_id',$id)->delete();
        VendorsCandidates::where('id',$id)->delete();  
        return redirect()->back()->with('message', 'Candidate deleted successfully');
    }
    public function destroy($id)
    {    
        
            JobApplied::where('candidate_id',$id)->delete();
            $profile_id = Profile::where('user_id', $id)->pluck('id')->first();
            Education::where('profile_id',$profile_id)->delete();
            Experience::where('profile_id',$profile_id)->delete();
            Profile::where('user_id', $id)->delete();
            DB::delete('delete from role_user where user_id = ?',[$id]);
            User::where('id', $id)->delete();
        
        return redirect()->back()->with('message', 'Candidate deleted successfully');
    }
    public function email_exist(Request $request)
    {
       $data= User::where('email','like','%{$request->email}%')->get();
    }
    public function show_applied_job(Request $request)
    {   
       $jobs = DB::table('jobs')->join('job_applieds', 'jobs.id', '=', 'job_applieds.job_id')
       ->select('jobs.*', 'job_applieds.applied_date', 'job_applieds.status as applied_status')
       ->orderBy('id','DESC')->where('candidate_id',Auth::user()->id)->get();

       return view('applied-jobs',compact('jobs'));
    }
    
    public function update_education_by_vendor(Request $request)
    {   
        $id =  $request->user_id;
        $request->validate([
            'level'                        =>  'required',
            'university'                   =>  'required',
            'course'                       =>  'required',
            'percentage'                   =>  'required',
            'education_start_year'         =>  'required',
            'education_end_year'           =>  'required',
        ]);
        Education::create([
            'profile_id'         =>  $id,
            'level'              =>  $request->level,
            'course'             =>  $request->course,
            'university'         =>  $request->university,
            'percentage'         =>  $request->percentage,
            'start_year'         =>  $request->education_start_year,
            'end_year'           =>  $request->education_end_year,
        ]);
        $educations =   Education::where('profile_id','=',$id)->get();
        return json_encode($educations);
    }

    public function update_experience_by_vendor(Request $request)
    {
        $request->validate([
            'level'                         =>  'required',
            'designation'                   =>  'required',
            'department'                    =>  'required',
            'organisation'                  =>  'required',
            'experience_start_year'         =>  'required',
            'experience_end_year'           =>  'required',
        ]);
        $id =  $request->user_id;
        Experience::create([
            'profile_id'         =>  $id,
            'level'              =>  $request->level,
            'designation'        =>  $request->designation,
            'department'         =>  $request->department,
            'organisation'       =>  $request->organisation,
            'start_year'         =>  $request->experience_start_year,
            'end_year'           =>  $request->experience_end_year,
        ]);
        $experiences =   Experience::where('profile_id','=',$id)->get();
        return json_encode($experiences);
    }
    public function filter_candidates(Request $request){
       
        $messages = [
            'job_id.required'         => 'Please Select a Job for filter',
        ];
        $request->validate([
            'job_id'                      =>  'required',
        ],$messages);
        $job_id=$request->job_id;

        
        if(Auth::user()->hasRole('Vendor')){
            
            $jobs= Job::where('approved_by','!=',NULL)->where('status',1)->where('job_expiry_date' ,'>', date('Y-m-d'))->get();
            $vendor_users_id    =   User::where('created_by', Auth::user()->id)->select('id')->get();
            $candidates_id   =   JobApplied::where('job_id',$job_id)->whereIn('candidate_id',$vendor_users_id)->where('status',0)->pluck('candidate_id');
            $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');
            $users['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob')->get();
            $users['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
            $users['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
           
            $users['appliedcandidates'] = JobApplied::where('job_id','=',$job_id)->whereIn('candidate_id',$candidates_id)->where('status','=','0')->select('id','applied_by','applied_date')->get();
            $users['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','email','phone')->get();
        }
        elseif(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('HR') || Auth::user()->hasRole('HR Manager') ){
        
        $jobs= Job::where('approved_by','!=',NULL)->where('job_expiry_date' ,'>', date('Y-m-d'))->where('status',1)->get();
        
        $candidates_id   =   JobApplied::where('job_id',$job_id)->pluck('candidate_id');
        $profile_id = Profile::whereIn('user_id',$candidates_id)->pluck('id');

        $users['profile']= Profile::whereIn('user_id',$candidates_id)->select('dob')->get();
        $users['candidate_exp'] = Experience::whereIn('profile_id',$profile_id)->select('level','start_year','end_year')->get();
        $users['candidate_edu'] = Education::whereIn('profile_id',$profile_id)->select('level','course','percentage')->get();
      
        $users['appliedcandidates'] = JobApplied::where('job_id','=',$job_id)->whereIn('candidate_id',$candidates_id)->select('id','applied_by','applied_date')->get();
        $users['candidate_detail'] = User::whereIn('id',$candidates_id)->select('id','name','status','email','phone')->get();
        
        $vendors_candidate_id = JobApplied::where('job_id',$job_id)->pluck('vendors_candidate_id');
        $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','start_year','end_year')->get();
        $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id',$vendors_candidate_id)->select('level','course','percentage')->get();
        $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id',$vendors_candidate_id)->select('id','name','email','status','phone','dob')->get();    
    
    }  
        return view('admin.candidate.index', compact('users','jobs', 'job_id','VendorsCandidates'));
    }

    public function filter_by_age(Request $request){
        $age = $request->age;
        $jobs = Job::where('approved_by', '!=', NULL)
                    ->where('job_expiry_date', '>', date('Y-m-d'))
                    ->where('status', 1)
                    ->get();
    
        $messages = [
            'age.required' => 'Please enter age first',
        ];
    
        $request->validate([
            'age' => 'required',
        ], $messages);
    
        $vendors_candidate_id = [];
        $candidates_id = [];
    
        if (Auth::user()->hasRole('Vendor')) {
            $VendorsCandidates['vendors_candidate_age'] = VendorsCandidates::select('dob', 'id')->get();
    
            foreach ($VendorsCandidates['vendors_candidate_age'] as $key => $user_age) {
                if (Carbon::parse($VendorsCandidates['vendors_candidate_age'][$key]->dob)->age == $age) {
                    $vendors_candidate_id[] = $VendorsCandidates['vendors_candidate_age'][$key]['id'];
                }
            }
    
            if (!empty($vendors_candidate_id)) {
                $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id', $vendors_candidate_id)
                                                                        ->select('level', 'start_year', 'end_year')
                                                                        ->get();
                $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id', $vendors_candidate_id)
                                                                        ->select('level', 'course', 'percentage')
                                                                        ->get();
                $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id', $vendors_candidate_id)
                                                                                    ->select('id', 'name', 'email', 'phone', 'dob')
                                                                                    ->get();
            }
        } else {
            $users['candidate_age'] = Profile::select('user_id', 'dob')
                                                ->where('user_id', '!=', NULL)
                                                ->get();
    
            foreach ($users['candidate_age'] as $key => $user_age) {
                if (Carbon::parse($users['candidate_age'][$key]->dob)->age == $age) {
                    $candidates_id[] = $users['candidate_age'][$key]['user_id'];
                }
            }
    
            if (!empty($candidates_id)) {
                $profile_id = Profile::whereIn('user_id', $candidates_id)->pluck('id');
                $users['profile'] = Profile::whereIn('user_id', $candidates_id)
                                            ->select('dob')
                                            ->get();
                $users['candidate_exp'] = Experience::whereIn('profile_id', $profile_id)
                                                    ->select('level', 'start_year', 'end_year')
                                                    ->get();
                $users['candidate_edu'] = Education::whereIn('profile_id', $profile_id)
                                                    ->select('level', 'course', 'percentage')
                                                    ->get();
    
                $users['candidate_detail'] = User::whereIn('id', $candidates_id)
                                                    ->select('id', 'name', 'status', 'email', 'phone')
                                                    ->get();
            }
    
            $VendorsCandidates['vendors_candidate_age'] = VendorsCandidates::select('dob', 'id')->get();
    
            foreach ($VendorsCandidates['vendors_candidate_age'] as $key => $user_age) {
                if (Carbon::parse($VendorsCandidates['vendors_candidate_age'][$key]->dob)->age == $age) {
                    $vendors_candidate_id[] = $VendorsCandidates['vendors_candidate_age'][$key]['id'];
                }
            }
    
            if (!empty($vendors_candidate_id)) {
                $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id', $vendors_candidate_id)
                                                                        ->select('level', 'start_year', 'end_year')
                                                                        ->get();
                $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id', $vendors_candidate_id)
                                                                        ->select('level', 'course', 'percentage')
                                                                        ->get();
                $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id', $vendors_candidate_id)
                                                                                    ->select('id', 'name', 'email', 'phone', 'dob')
                                                                                    ->get();
            }
        }
    
        $exp = null;
        return view('admin.candidate.index', compact('users', 'jobs', 'age', 'VendorsCandidates', 'exp'));
    }
    

    public function filter_by_exp(Request $request){

        $vendors_candidate_id = [];
    
        $jobs = Job::where('approved_by', '!=', NULL)
            ->where('job_expiry_date', '>', date('Y-m-d'))
            ->where('status', 1)
            ->get();
        
        $messages = [
            'exp.required' => 'Please select an experience range for filtering.',
        ];
        
        $request->validate([
            'exp' => 'required',
        ], $messages);
        
        $exp = $request->exp;
    
        if (Auth::user()->hasRole('Vendor')) {
            $VendorsCandidates['candidate_exp'] = Experience::select('vendors_user_id', 'start_year', 'end_year')
                ->where('vendors_user_id', '!=', NULL)
                ->get();
        
            foreach ($VendorsCandidates['candidate_exp'] as $key => $experience) {
                $totalDuration = 0;
        
                $startYears = json_decode($experience['start_year'], true);
                $endYears = json_decode($experience['end_year'], true);
        
                if (is_array($startYears) && is_array($endYears)) {
                    foreach ($startYears as $expkey => $start_year) {
                        if (array_key_exists($expkey, $endYears)) {
                            $startTime = Carbon::parse($start_year);
                            $endTime = Carbon::parse($endYears[$expkey]);
                            $totalDuration += $startTime->diffInMonths($endTime);
                        }
                    }
                }
        
                $total_exp = round($totalDuration / 12, 1);
        
                if ($exp === '0-5' && $total_exp >= 0 && $total_exp <= 5) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                } elseif ($exp === '5-10' && $total_exp > 5 && $total_exp <= 10) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                } elseif ($exp === '10-15' && $total_exp > 10 && $total_exp <= 15) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                } elseif ($exp === '15-20' && $total_exp > 15 && $total_exp <= 20) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                } elseif ($exp === '20-25' && $total_exp > 20 && $total_exp <= 25) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                } elseif ($exp === '25+' && $total_exp > 25) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                }
            }
        
            $id = VendorsCandidates::where('created_by', Auth::user()->id)->pluck('id')->toArray();
            $vendorss_candidate_id = array_intersect($id, $vendors_candidate_id);
        
            if ($vendorss_candidate_id != NULL) {
                $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id', $vendorss_candidate_id)
                    ->select('level', 'start_year', 'end_year')
                    ->get();
                
                $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id', $vendorss_candidate_id)
                    ->select('level', 'year')
                    ->get();
            }
        } else {
            $users['candidate_exp'] = Experience::select('profile_id', 'start_year', 'end_year')
                ->where('profile_id', '!=', NULL)
                ->get();
        
            foreach ($users['candidate_exp'] as $key => $start_year) {
                $totalDuration = 0;
        
                $startYears = json_decode($users['candidate_exp'][$key]['start_year'], true);
                $endYears = json_decode($users['candidate_exp'][$key]['end_year'], true);
        
                if (is_array($startYears) && is_array($endYears)) {
                    foreach ($startYears as $expkey => $start_year) {
                        if (array_key_exists($expkey, $endYears)) {
                            $startTime = Carbon::parse($start_year);
        
                            if ($endYears[$expkey] === 'Present') {
                                $endTime = Carbon::now();
                            } elseif ($endYears[$expkey] === '-') {
                                // Handle the "-" value, you can set it to a default value or skip the calculation
                                continue;
                            } else {
                                $endTime = Carbon::parse($endYears[$expkey]);
                            }
        
                            $totalDuration += $startTime->diffInMonths($endTime);
                        }
                    }
                }
        
                $total_exp[$key] = round($totalDuration / 12, 1);
        
                if ($exp === '0-5' && $total_exp[$key] >= 0 && $total_exp[$key] <= 5) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                } elseif ($exp === '5-10' && $total_exp[$key] > 5 && $total_exp[$key] <= 10) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                } elseif ($exp === '10-15' && $total_exp[$key] > 10 && $total_exp[$key] <= 15) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                } elseif ($exp === '15-20' && $total_exp[$key] > 15 && $total_exp[$key] <= 20) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                } elseif ($exp === '20-25' && $total_exp[$key] > 20 && $total_exp[$key] <= 25) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                } elseif ($exp === '25+' && $total_exp[$key] > 25) {
                    $profils_id[] = $users['candidate_exp'][$key]['profile_id'];
                }

                
            }
        
            if ($profils_id != NULL) {
                $candidates_id = Profile::whereIn('id', $profils_id)->pluck('user_id');
                $profile_id = Profile::whereIn('user_id', $candidates_id)->pluck('id');
        
                $users['profile'] = Profile::whereIn('user_id', $candidates_id)
                    ->select('dob')
                    ->get();
        
                $users['candidate_exp'] = Experience::whereIn('profile_id', $profile_id)
                    ->select('level', 'start_year', 'end_year')
                    ->get();
        
                $users['candidate_edu'] = Education::whereIn('profile_id', $profile_id)
                    ->select('level', 'course', 'percentage')
                    ->get();
        
                // $users['appliedcandidates'] = JobApplied::where('job_id', '=', $job_id)
                //     ->whereIn('candidate_id', $candidates_id)
                //     ->select('id', 'applied_by', 'applied_date')
                //     ->get();
        
                $users['candidate_detail'] = User::whereIn('id', $candidates_id)
                    ->select('id', 'name', 'status', 'email', 'phone')
                    ->get();
            }
        
            $VendorsCandidates['candidate_exp'] = Experience::select('vendors_user_id', 'start_year', 'end_year')
                ->where('vendors_user_id', '!=', NULL)
                ->get();
        
            foreach ($VendorsCandidates['candidate_exp'] as $key => $start_year) {
                $totalDuration = 0;
        
                $startYears = json_decode($VendorsCandidates['candidate_exp'][$key]['start_year'], true);
                $endYears = json_decode($VendorsCandidates['candidate_exp'][$key]['end_year'], true);
        
                if (is_array($startYears) && is_array($endYears)) {
                    foreach ($startYears as $expkey => $start_year) {
                        if (array_key_exists($expkey, $endYears)) {
                            $startTime = Carbon::parse($start_year);
                            $endTime = Carbon::parse($endYears[$expkey]);
                            $totalDuration += $startTime->diffInMonths($endTime);
                        }
                    }
                }
        
                $total_exp[$key] = round($totalDuration / 12, 1);
        
                if ($total_exp[$key] >= $request->exp) {
                    $vendors_candidate_id[] = $VendorsCandidates['candidate_exp'][$key]['vendors_user_id'];
                }
            }
        
            if ($vendors_candidate_id != NULL) {
                $VendorsCandidates['vendors_candidate_exp'] = Experience::whereIn('vendors_user_id', $vendors_candidate_id)
                    ->select('level', 'start_year', 'end_year')
                    ->get();
        
                $VendorsCandidates['vendors_candidate_edu'] = Education::whereIn('vendors_user_id', $vendors_candidate_id)
                    ->select('level', 'course', 'percentage')
                    ->get();
        
                $VendorsCandidates['vendors_candidate_detail'] = VendorsCandidates::whereIn('id', $vendors_candidate_id)
                    ->select('id', 'name', 'email', 'status', 'phone', 'dob')
                    ->get();
            }
        
        }
     
        $age = 'null';
        return view('admin.candidate.index', compact('users', 'jobs', 'exp', 'age', 'VendorsCandidates'));
        
    }
    
    
    }
    
    
