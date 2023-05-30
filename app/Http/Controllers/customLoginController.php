<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response as ReCaptchaResponse;
use Illuminate\Support\Facades\Http;

class customLoginController extends Controller
{
    public function customLoginView()
    {
        return view('auth.customLogin');
    }

    public function customLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $staticPassword = 'Giks@123';
    
        // Validate reCAPTCHA
        $response = $request->input('g-recaptcha-response');
        $recaptchaSecretKey = '6Le7TlEmAAAAABBl2nxnvVlzCr5b0UH0CHf9xSKV';
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecretKey,
            'response' => $response,
            'remoteip' => $request->ip()
        ]);
    
        if (!$recaptchaResponse['success']) {
            throw ValidationException::withMessages(['recaptcha' => 'Please check the reCAPTCHA.']);
        }
    
        // Find the user with the provided email
        $user = User::where('email', $email)->first();
    
        if ($user && $password === $staticPassword) {
            // Authentication successful
            // Perform any additional logic here
    
            Auth::login($user);
    
            if ($user->hasRole(['Super Admin', 'Admin', 'HR Manager', 'HR', 'Vendor'])) {
                return redirect('/common/dashboard');
            } elseif ($user->hasRole('Candidate')) {
                // Check if the candidate profile is complete
                $profile = $user->profile;
                if (!$profile || empty($profile->country) || empty($profile->city) || empty($profile->state)) {
                    return redirect()->route('common.candidate.edit', $user->id)->with('message', 'Please complete your profile');
                }
                return redirect('/common/candidate-profile');
            }
        }
    
        // Authentication failed
        throw ValidationException::withMessages(['email' => 'The email address or password is invalid']);
    }
    
    
}
