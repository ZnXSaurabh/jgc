<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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

        // Find the user with the provided email
        $user = User::where('email', $email)->first();

        if ($user && $password === $staticPassword) {

            // dd($user);

            // Authentication successful
            // Perform any additional logic here

            Auth::login($user);

            if ($user->hasRole(['Super Admin', 'Admin', 'HR Manager', 'HR', 'Vendor'])) {
                // dd($user);
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
        return redirect()->back()->withInput()->withErrors(['email' => 'The email address or password is invalid']);


    }
    
}
