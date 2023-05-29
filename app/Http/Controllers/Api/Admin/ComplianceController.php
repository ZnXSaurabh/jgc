<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Compliance;
use App\Models\Compliance_Token;
use Mail;
use App\Mail\ComplianceApply;
use Illuminate\Support\Str;

class ComplianceController extends Controller
{
    //

    public function apply(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // 422 is the HTTP status code for unprocessable entity
            }


            $randomNumber = rand(100, 999);

            $token = Str::random($randomNumber);
            $token = substr($token, 0, 182);

            $compliance = new Compliance_Token;

            $compliance->fullname = $request->fullname;
            $compliance->email = $request->email;
            $compliance->token = $token;

            if($compliance->save()){

                $url = 'https://jgc.com.sa/comliance-register/'.$token;

                $mailStatus = Mail::to($request->email)->later(now()->addSeconds(3), new ComplianceApply($request->fullname, $url));

                    $response = [
                        'mailStatus' => $mailStatus,
                        'message' => 'mail send successfully.',
                    ];

                    return response($response,200);
            }
            else{
                
                return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
    
            }
            
        }
        catch(Exception $e){
            return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
        }
    }

    public function getCompliance(Request $request, $token){
        try{

            // $validator = Validator::make($request->all(), [
            //     'mobile' => 'required|max:10|regex:/^[0-9]{10}$/',
            //     'name' => 'required|max:255',
            // ]);
        
            // if ($validator->fails()) {
            //     return response()->json([
            //         'error' => 'Validation failed',
            //         'errors' => $validator->errors(),
            //     ], 422); // 422 is the HTTP status code for unprocessable entity
            // }


                    $response = [
                        'token' => $token,
                        'message' => 'function called successfully.',
                    ];

                    return response($response,200);
                
            
        }
        catch(Exception $e){
            return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
        }
    }

    public function registerCompliance(Request $request,$token){
        try{

            // $validator = Validator::make($request->all(), [
            //     'mobile' => 'required|max:10|regex:/^[0-9]{10}$/',
            //     'name' => 'required|max:255',
            // ]);
        
            // if ($validator->fails()) {
            //     return response()->json([
            //         'error' => 'Validation failed',
            //         'errors' => $validator->errors(),
            //     ], 422); // 422 is the HTTP status code for unprocessable entity
            // }


                    $response = [
                        'token' => $token,
                        'message' => 'function called successfully.',
                    ];

                    return response($response,200);
                
            
        }
        catch(Exception $e){
            return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
        }
    }
}



