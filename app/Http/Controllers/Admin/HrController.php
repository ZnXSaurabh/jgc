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
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\HrRegistration;
use App\Http\Controllers\Controller;

class HrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   if(Auth::user()->hasRole('HR Manager'))
        {
        $HrUsers = User::where('created_by','=',Auth::user()->id)->whereHas('roles', function($q){
            $q->where('title', 'HR');
        })->get();
    }else{
        $HrUsers = User::whereHas('roles', function($q){
            $q->where('title', 'HR');
        })->get();
    }
        return view('admin.hr.index',compact('HrUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries  =   Country::all();
        return view('admin.hr.create', compact('countries'));
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
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            // 'phone.required'        => 'Mobile Number is required.',
            // 'phone.numeric'         => 'Mobile Number must be numeric.',
            // 'phone.min'             => 'Mobile Number must be of 10 characters.',
            // 'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
            'emp_no.required'       => 'Employee Number field is required.',
            
        ];

        $request->validate([
            'name'            =>  'required|max:191',
            'email'           =>  'required|email|unique:users',
            // 'phone'           =>  'required|numeric|min:10|unique:users',
            'employee_no'         =>  'required',
            
        ], $messages);
        $user   = User::create([
            'name'    => ucwords($request->name),
            'email'   => $request->email,
            // 'phone'   => $request->phone,
            'created_by'=>  Auth::user()->id,
        ]);
        $user->roles()->sync(5);
        Profile::create([
            'user_id'       =>  $user->id,
            'emp_no'       =>   $request->employee_no,

        ]);
        //Send token
        UserToken::create([
          'user_id' => $user->id,
          'token'   => Str::random(50)
        ]);
        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
            'email' =>  $user->email,
        ]));
        Mail::to($user->email)->later(now()->addSeconds(5), new HrRegistration($user, $url));
        return redirect()->route('admin.hr.index')->with('message', 'HR added successfully please check email for login link');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hr = Profile::where('user_id','=',$id)->first();
        return view('admin.hr.show',compact('hr'));
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
        $hr = Profile::where('user_id','=',$id)->first();
        return view('admin.hr.edit',compact('hr', 'countries'));
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
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            // 'phone.required'        => 'Mobile Number is required.',
            // 'phone.numeric'         => 'Mobile Number must be numeric.',
            // 'phone.min'             => 'Mobile Number must be of 10 characters.',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
            'emp_no.required'       => 'Employee Number field is required.',
        ];
        $request->validate([
            'name'            =>  'required|max:191',
            'email'           =>  'required|email|unique:users,email,'.$id,
            // 'phone'           =>  'required|numeric|min:10|unique:users,phone,'.$id,
            'employee_no'     =>  'required',
        ], $messages);
        User::where('id','=',$id)->update([
            'name'      =>  ucwords($request->name),
            'email'     =>  $request->email,
            // 'phone'     =>  $request->phone,
            'status'    =>  $request->status,
        ]);
        Profile::where('user_id','=',$id)->update([
            'emp_no'       =>   $request->employee_no,
        ]);
        return redirect()->route('admin.hr.index')->with('message', 'HR updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        Job::where('user_id',$id)->delete();
        DB::delete('delete from role_user where user_id = ?',[$id]);
        Profile::where('user_id', $id)->delete();
        User::where('id', $id)->delete(); 
      
        return redirect()->back()->with('message', 'HR deleted successfully');
    }
}