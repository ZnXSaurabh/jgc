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

            $key="fbuiasytf76weft4fygwe3r976fg3ry7fgwr97yrg3r7fybreyg34rfyg3yrfgreyfg3796gf8ryrfg3487";

            $hashedToken = $request->bearerToken();

            if($hashedToken == $key){
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                ]);
    
                if ($validator->fails()) {
                    return response()->json([
                        'error' => 'Validation failed',
                        'errors' => $validator->errors(),
                    ], 422); 
                }
    
    
                $randomNumber = rand(100, 999);
    
                $token = Str::random($randomNumber);
                $token = substr($token, 0, 182);
    
                $compliance = new Compliance_Token;
    
                $compliance->fullname = $request->fullname;
                $compliance->email = $request->email;
                $compliance->token = $token;
    
                if($compliance->save()){
    
                    $url = 'https://jgc.com.sa/compliance-register/'.$token;
    
                    $mailStatus = Mail::to($request->email)->later(now()->addSeconds(3), new ComplianceApply($request->fullname, $url));
    
                        $response = [
                            'mailStatus' => $mailStatus,
                            'message' => 'mail send successfully.',
                        ];
    
                        return response($response,200);
                }
                else{
                    
                    return response([
                        'message' => "Internal Server Error.",
                    ],500); 
        
                }
            }
            else{
                return response([
                    'message' => "Unauthorized user.",
                ],401);
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

            $key="fbuiasytf76weft4fygwe3r976fg3ry7fgwr97yrg3r7fybreyg34rfyg3yrfgreyfg3796gf8ryrfg3487";

            $hashedToken = $request->bearerToken();

            if($hashedToken == $key){
    
                $complianceUser = Compliance_Token::where('token',$token)->first();

                if($complianceUser){
                    $response = [
                        'response' => $complianceUser,
                        'message' => 'Data found successfully.',
                    ];
                    return response($response,200);
                }
                else{
                    $response = [
                        'message' => 'No such compliance report found.',
                    ];

                    return response($response,422);
                }
            }
            else{
                return response([
                    'message' => "Unauthorized user.",
                ],401);
            }
            
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

            $key="fbuiasytf76weft4fygwe3r976fg3ry7fgwr97yrg3r7fybreyg34rfyg3yrfgreyfg3796gf8ryrfg3487";

            $hashedToken = $request->bearerToken();

            if($hashedToken == $key){

                $complianceUser = Compliance_Token::where('token',$token)->first();

                if($complianceUser){

                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'mobile' => 'nullable|max:10|regex:/^[0-9]{10}$/',
                    'fullname' => 'nullable|max:185',
                    'category' => 'required|max:185',
                    'message' => 'required|max:255',
                    'attachment' => 'nullable|mimes:pdf,doc,docx,jpg,jpef,png|max:50000',
                ]);
            
                if ($validator->fails()) {
                    return response()->json([
                        'error' => 'Validation failed',
                        'errors' => $validator->errors(),
                    ], 422); // 422 is the HTTP status code for unprocessable entity
                }


                $complianceRegister = new Compliance;
                $complianceRegister->fullname = $request->fullname;
                $complianceRegister->email = $request->email;
                $complianceRegister->mobile = $request->mobile;
                $complianceRegister->category = $request->category;
                $complianceRegister->message = $request->message;
                $complianceRegister->attachment = null;

                if($request->hasfile('attachment')){

                    $attachment = $request->file('attachment');
        
                    $renameAttachment = rand(100,1000000000).'.'.$attachment->getClientOriginalExtension();
        
                    $attachmentDestination = public_path('/compliance');
        
                    $attachment->move($attachmentDestination,$renameAttachment);
        
                    // save data 
        
                    $complianceRegister->attachment = $renameAttachment;
        
                }

                if($complianceRegister->save()){

                    Compliance_Token::where('token',$token)->delete();
    
                    // $mailStatus = Mail::to($request->email)->later(now()->addSeconds(3), new ComplianceApply($request->fullname, $url));
    
                        $response = [
                            // 'mailStatus' => $mailStatus,
                            'message' => 'compliance register successfully.',
                        ];
    
                        return response($response,200);
                }
                else{
                    
                    return response([
                        'message' => "Internal Server Error.",
                    ],500); 
        
                }

            }
            else{
                $response = [
                    'message' => 'No such compliance report found.',
                ];

                return response($response,422);
            }

            }
            else{
                return response([
                    'message' => "Unauthorized user.",
                ],401);
            }
        }
        catch(Exception $e){
            return response([
                    'errors' => $e->message(),
                    'message' => "Internal Server Error.",
                ],500); 
        }
    }
}



