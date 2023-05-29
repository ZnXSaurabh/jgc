<?php
namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Mail;
use App\User;
use App\UserToken;
use App\Models\Job;
use App\Models\Vendor;
use App\Models\Profile;
use App\Models\Country;
use App\Models\JobApplied;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Mail\VendorRegistration;
use App\Http\Controllers\Controller;

class HRManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $hr_managers = User::whereHas('roles', function($q){
            $q->where('title', 'HR Manager');
        })->get();
        return view('admin.hr-managers.index',compact('hr_managers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries  =   Country::all();
        return view('admin.hr-managers.create', compact('countries'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $messages = [
            'name.required'   => 'Fullname field is required.',
            'name.max'        => 'Fullname field must be less than 191 characters',
            // 'phone.required'  => 'Mobile Number is required.',
            // 'phone.numeric'   => 'Mobile Number must be numeric.',
            // 'phone.min'       => 'Mobile Number must be of 10 characters.',
            // 'phone.unique'    => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'    => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'  => 'Email field is required.',
            'employee_no.required'  => 'Employee Number field is required.',
        ];
        $request->validate([
            'name'            =>  'required|max:191',
            'email'           =>  'required|email|unique:users',
            'employee_no'      =>  'required',    
            // 'phone'           =>  'required|numeric|min:10|unique:users',
            // 'address'         =>  'required',
            // 'city'            =>  'required',
            // 'state'           =>  'required',
            // 'pincode'         =>  'required',
            // 'dob'             =>  'required',
            // 'gender'          =>  'required',
        ], $messages);
        $user   =   User::create([
            'name'    => ucwords($request->name),
            'email'   => $request->email,
            'phone'   => $request->phone,
            'created_by'=>  Auth::user()->id,
        ]);
        $user->roles()->sync(4);
        Profile::create([
            'user_id'       => $user->id,
            'emp_no'    =>  $request->employee_no,
            // 'user_id'       => $user->id,
            // 'address'       => ucwords($request->address),
            // 'country'       => ucwords($request->country),
            // 'city'          => ucwords($request->city),
            // 'state'         => ucwords($request->state),
            // 'zip_code'      => ucwords($request->pincode),
            // 'about'         => ucwords($request->about),
            // 'dob'           => $request->dob,
            // 'gender'        => $request->gender,
        ]);
        //Send token
        UserToken::create([
            'user_id' => $user->id,
            'token'   => Str::random(50)
        ]);
        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
            'email' =>  $user->email,
        ]));
        Mail::to($user->email)->later(now()->addSeconds(5), new VendorRegistration($user, $url));
        return redirect()->route('admin.hr_manager.index')->with('message', 'HR Manager added successfully please check email for login link');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hr_manager= Profile::where('user_id','=',$id)->first();
        return view('admin.hr-managers.show',compact('hr_manager'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries  =   Country::all();
        $hr_manager = Profile::where('user_id','=',$id)->first();
        return view('admin.hr-managers.edit',compact('hr_manager','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required'   => 'Fullname field is required.',
            'name.max'        => 'Fullname field must be less than 191 characters',
            // 'phone.required'  => 'Mobile Number is required.',
            // 'phone.numeric'   => 'Mobile Number must be numeric.',
            // 'phone.min'       => 'Mobile Number must be of 10 characters.',
            'email.unique'    => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'    => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'  => 'Email field is required.',
            'employee_no.required'  => 'Employee Number field is required.',
        ];
        $request->validate([
            'name'            =>  'required|max:191',
            'email'           =>  'required|email|unique:users,email,'.$id,
            'employee_no'      =>  'required',    
            // 'phone'           =>  'required|numeric|min:10|unique:users,phone,'.$id,
            // 'address'         =>  'required',
            // 'city'            =>  'required',
            // 'state'           =>  'required',
            // 'pincode'         =>  'required',
            // 'dob'             =>  'required',
            // 'gender'          =>  'required',
        ], $messages);

        Profile::where('user_id','=',$id)->update([
            'emp_no'    =>  $request->employee_no,
            // 'address'       => ucwords($request->address),
            // 'country'       => ucwords($request->country),
            // 'city'          => ucwords($request->city),
            // 'state'         => ucwords($request->state),
            // 'zip_code'      => ucwords($request->pincode),
            // 'about'         => ucwords($request->about),
            // 'dob'           => $request->dob,
            // 'gender'        => $request->gender,
        ]);
        User::where('id','=',$id)->update([
            'name'          => ucwords($request->name),
            'email'         => $request->email,
            'phone'         => $request->phone,
            'status'        => $request->status,
        ]);
        return redirect()->route('admin.hr_manager.index')->with('message', 'HR Manager updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        DB::delete('delete from role_user where user_id = ?',[$id]);
        Profile::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        

        return redirect()->back()->with('message', 'HR Manager deleted successfully');
    }
    public function job_approve($id)
    {  
        Job::where('id','=',$id)->update(
            [
                'approved_by' =>  Auth::user()->id,
                'status'      =>  1,
                'posting_date'=>  date('yy-m-d'),
            ]
        );
        return redirect()->route('common.approved_jobs');
    }
     
}
