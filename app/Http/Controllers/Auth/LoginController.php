<?php

namespace App\Http\Controllers\Auth;

use DB;
use Auth;
use Mail;
use App\User;
use App\UserToken;
use Carbon\Carbon;
use App\Mail\UserLogin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CandidateRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/common/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request, $token)
    {   
        $userToken = UserToken::where("token", $token)->first();

        if ($userToken == NULL) {
            return view('errors/illustrated-layout');
        }

        Auth::login($userToken->user, $request->get('remember'));

        if (!$userToken == NULL) {
            $userToken->delete();
        }
        
        if (Auth::check()) {
            if (
                Auth::user()->hasRole('Super Admin') ||
                Auth::user()->hasRole('Admin') ||
                Auth::user()->hasRole('HR Manager') ||
                Auth::user()->hasRole('HR') ||
                Auth::user()->hasRole('Vendor')
            ) {
                return redirect('common/dashboard');
            } else if (Auth::user()->hasRole('Candidate')) {
                $user = User::findOrFail(Auth::user()->id);
                if ($user->profile->country == '' || $user->profile->city == '' || $user->profile->state == '') {
                    return redirect()->route('common.candidate.edit', Auth::user()->id)->with('message', 'Please complete your profile.');
                }
                return redirect('common/candidate-profile');
            }
        }
    }

    protected function authenticated(Request $request, $user)
    {   
        if (Auth::check()) {
            if (
                Auth::user()->hasRole('Super Admin') ||
                Auth::user()->hasRole('Admin') ||
                Auth::user()->hasRole('HR Manager') ||
                Auth::user()->hasRole('HR') ||
                Auth::user()->hasRole('Vendor')
            ) {
                return redirect('common/dashboard');
            } else if (Auth::user()->hasRole('Candidate')) {   
                return redirect('common/candidate-profile');
            }
        }
    }

    public function sendToken(Request $request)
    {   
        $this->validate($request, [
            'email' => 'required|email|max:255|exists:users,email',
            'g-recaptcha-response' => 'required',
        ]);

        $captchaResponse = $request->input('g-recaptcha-response');
        $secretKey = '6LeE2TsmAAAAAN8pSuswFdERu_WXMjg7lLSZgb1l';
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $data = [
            'secret' => $secretKey,
            'response' => $captchaResponse,
            'remoteip' => $request->ip(),
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);

        if (!$response || !$response->success) {
            // reCAPTCHA validation failed
            return redirect()->back()->withErrors(['captcha' => 'The reCAPTCHA verification failed.']);
        }

        $user = User::where('email', $request->email)->where('deleted_at', NULL)->first();
        UserToken::create([
            'user_id' => $user->id,
            'token'   => Str::random(50)
        ]);

        $url = url('/login_link/' . $user->token->token . '?' . http_build_query([
            'email' =>  $user->email,
        ]));

        Mail::to($user->email)->later(now()->addSeconds(5), new UserLogin($user, $url));

      
    }
}
