<?php
namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Mail;
use App\User;
use App\UserToken;
use App\Models\Country;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VendorRegistration;
use App\Http\Controllers\Controller;


class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('HR'))
        {
            $vendors = Vendor::join('users','vendor.user_id','=','users.id')->where('created_by','=',Auth::user()->id)->get();
        }elseif(Auth::user()->hasRole('Vendor')){
            $vendors = Vendor::join('users','vendor.user_id','=','users.id')->where('created_by','=',Auth::user()->id)->get();
        }else{
            $vendors= Vendor::all();
        }
        return view('admin.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $countries  =   Country::all();
        return view('admin.vendors.create',compact('countries'));
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
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.min'             => 'Mobile Number must be of 10 characters.',
            'email.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];
        $request->validate([
            'name'          =>  'required|max:191',
            'email'         =>  'required|email|unique:users',
            'phone'         =>  'required|numeric|min:10|unique:users',
            'city'          =>  'required',
            'zip_code'      =>  'required',
            'address'       =>  'required',
        ], $messages);

        $user   = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'created_by'    => Auth::user()->id,
        ]);
        $user->roles()->sync(6);

        $data                       =   new Vendor;
        $data->user_id              =   $user->id;
        $data->vendor_reg_no        =   "reg-".date("YmdHis");
        $data->vendor_service_id_no =   "service-".date("YmdHis");
        $data->city                 =   $request->city;
        $data->state                =   $request->state;
        $data->zip_code             =   $request->zip_code;
        $data->country              =   $request->country;
        $data->address              =   $request->address;
        $data->save();
        //Send token
        UserToken::create([
            'user_id' => $user->id,
            'token'   => Str::random(50)
        ]);
        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
            'email' =>  $user->email,
        ]));
        Mail::to($user->email)->later(now()->addSeconds(5), new VendorRegistration($user, $url));
        return redirect()->route('admin.vendor.index')->with('message', 'Vendor add successfully please check email for login link');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $vendor = vendor::where('id','=',$id)->first();
        return view('admin.vendors.show',compact('vendor'));
    }
    public function getShowVendor($id)
    { 
        $vendor = DB::table('users')->join('vendors', 'users.id', '=', 'vendors.user_id')->select('users.name','users.email','users.phone', 'vendors.*')->where('user_id',$id)->first();
       
        return json_encode($vendor);
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
        $vendor     =   vendor::where('user_id','=',$id)->first();
        return view('admin.vendors.edit', compact('vendor','countries'));
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
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.min'             => 'Mobile Number must be of 10 characters.',
            'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];
        $request->validate([
            'name'          =>  'required|max:191',
            'email'         =>  'required|email|unique:users,email,'.$id,
            'phone'         =>  'required|numeric|min:10|unique:users,phone,'.$id,
            'city'          =>  'required',
            'zip_code'      =>  'required',
            'address'       =>  'required',
        ], $messages);

        $user = User::findOrFail($id);
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->save();

        Vendor::where('id','=',$id)->update([
            'city'   =>$request->city,
            'state'  =>$request->state,
            'zip_code'=>$request->zip_code,
            'address' =>$request->address,
            'country' =>$request->country
        ]);
        return redirect()->route('admin.vendor.index')->with('message', 'Vendor updated successfully please check email for login link');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
       $user_id = Vendor::where('id', $id)->pluck('user_id')->first();
       DB::delete('delete from role_user where user_id = ?',[$user_id]);
       Vendor::where('id', $id)->delete();
       User::where('id',$user_id)->delete();
        return redirect()->back()->with('message', 'Vendor deleted successfully');
    }
}