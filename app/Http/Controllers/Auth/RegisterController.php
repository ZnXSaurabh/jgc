<?php
namespace App\Http\Controllers\Auth;

use Mail;
use DB;
use App\User;
use App\UserToken;
use App\Mail\UserLogin;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response as ReCaptchaResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    // protected $redirectTo = '/candidate-profile';

    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function validator(array $data)
    {
        $messages = [
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.digits_between'  => '<br>Mobile Number must be between 10 and 20 digits.',
            'phone.unique'          => 'This phone number is already registerd with our talentpool. Try with another number',
            'email.unique'          => 'This email is already registerd with our talentpool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];
        return Validator::make($data, [
            'name'          =>  'required|max:191||regex:/^[\pL\s\-]+$/u',
            'email'         =>  'required|email|unique:users',
            'phone'         =>  'required|numeric|digits_between:10,20|unique:users',
        ],$messages);
    }

    protected function create(Request $request)
    {   
        $postData = $request->all();

        $messages = [
            'name.required'         => 'Fullname field is required.',
            'name.max'              => 'Fullname field must be less than 191 characters',
            'phone.required'        => 'Mobile Number is required.',
            'phone.numeric'         => 'Mobile Number must be numeric.',
            'phone.digits_between'  => '<br>Mobile Number must be between 10 and 20 digits.',
            'phone.unique'          => 'This phone number is already registered with our talent pool. Try with another number',
            'email.unique'          => 'This email is already registered with our talent pool. Try with another email',
            'email.required'        => 'Email field is required.',
        ];

        $validator = Validator::make($postData, [
            'name'  => 'required|max:191||regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|digits_between:10,20|unique:users',
        ], $messages);

        if ($validator->fails()) {
            $response = new \stdClass();
            $response->status = false;
            $response->errors = $validator->errors();
            return response()->json($response, 400);
        }

        // Verify reCAPTCHA response
        $captchaResponse = $postData['g-recaptcha-response'];
        $recaptcha = new ReCaptcha('6Le7TlEmAAAAABBl2nxnvVlzCr5b0UH0CHf9xSKV');
        $recaptchaResponse = $recaptcha->verify($captchaResponse);

        if (!$recaptchaResponse->isSuccess()) {
            // reCAPTCHA verification failed
            $response = new \stdClass();
            $response->status = false;
            $response->message = "reCAPTCHA verification failed";
            return response()->json($response, 400);
        }

        $user = new User;
        $user->name = $postData['name'];
        $user->email = $postData['email'];
        $user->phone = $postData['phone'];

        if ($user->save()) {
            $profile = new Profile;
            $profile->user_id = $user->id;

            if ($profile->save()) {
                $exp = new Experience;
                $exp->profile_id = $profile->id;
                $exp->save();
            }
        }

        $user->roles()->sync(3);

        $userToken = new UserToken;
        $userToken->user_id  = $user->id;
        $userToken->token = Str::random(50);
        $userToken->save();

        $url = url('/login_link/' . $userToken->token . '?' . http_build_query([
            'email' => $user->email,
        ]));

        Mail::to($user->email)->send(new UserLogin($user, $url));

        $response = new \stdClass();
        $response->status = true;
        return response()->json($response);

    }

    public function resendLoginEmail(Request $request){
        
        $user = User::where('email',$request->email)->first();
        UserToken::where('user_id',$user->id)->delete(); 
        UserToken::create([
         'user_id' => $user->id,
         'token'   => Str::random(50)
         ]);
        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
         'email' =>  $user->email,
        ]));
    
        Mail::to($user->email)->send(new UserLogin($user, $url));
        
        return $user;
     }
}
