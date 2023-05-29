<?php

namespace App\Http\Controllers\Api\Admin;
use DB;
use Auth;
use Mail;
use App\User;
use App\UserToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request){
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if(Auth::login($request->email,$request->get('remember'))){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return 'Unauthorised.';
        } 
    }
    
}
