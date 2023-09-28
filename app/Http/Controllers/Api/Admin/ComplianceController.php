<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Compliance;
use App\Models\Compliance_Token;
use Mail;
use App\Mail\ComplianceApply;
use App\Mail\ComplianceRegister;
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
                $complianceRegister->phonenumber = $request->mobile;
                $complianceRegister->category = $request->category;
                $complianceRegister->message = $request->message;
                $complianceRegister->fileurl = null;

                if($request->hasfile('attachment')){

                    $attachment = $request->file('attachment');
                    $fileName = $attachment->getClientOriginalName();
                    $FileExt = $attachment->getClientOriginalExtension();
                    $contentType = $attachment->getClientMimeType();

                    $renameAttachment = rand(100,1000000000).'.'.$attachment->getClientOriginalExtension();
        
                    $attachmentDestination = public_path('/compliance');
        
                    $attachment->move($attachmentDestination,$renameAttachment);
        
                    // save data 
        
                    $complianceRegister->fileurl = "/compliance/".$renameAttachment;
                    $complianceRegister->fileName = $fileName;
                    $complianceRegister->FileExt = $FileExt;
                    $complianceRegister->contentType = $contentType;
        
                }

                if($complianceRegister->save()){

                    Compliance_Token::where('token',$token)->delete();
    
                    $mailStatus = Mail::to($request->email)->later(now()->addSeconds(3), new ComplianceRegister($request->fullname));
    
                        $response = [
                            'mailStatus' => $mailStatus,
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

    public function complianceList(Request $request){
        try{

            $key = $request->key;

            if($key == "AIzaSyARU2rr8X3qHFSAD3F3434F42RFbrz72oVswps5VMjldNFHW4"){

                $allcompliance = Compliance::select('id','fullname','email','phonenumber','category','message','fileurl','fileName','FileExt','contentType','status','created_at')->get();

                return response($allcompliance, 200);

            }
            else{
                return response([
                    'message' => "Not Authorized",
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


    public function updateCompliance(Request $request){
        try{
            $key = $request->key;
            if($key == "AIzaSyARU2rr8X3qHFSAD3F3434F42RFbrz72oVswps5VMjldNFHW4"){
                
                $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'status' => 'required',
                ]);
    
                if ($validator->fails()) {
                    return response()->json([
                        'error' => 'Validation failed',
                        'errors' => $validator->errors(),
                    ], 422); 
                }

                $complianceRequest = Compliance::where('id',$request->id)->first();                
                if(!empty($complianceRequest )){
                    if($request->status == "pass") {
                        if($complianceRequest->fileurl){
                            $filePath = public_path($complianceRequest->fileurl);
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                        }
    
                        if($complianceRequest->delete()){
                            return response([
                                'message' => "Compliance ID ".$request->id." deleted successfully!!!",
                                ],200);
                        }
                        else{
                            return response([
                                'message' => "Oops there is something wrong!!!",
                                ],500);
                        }
                    }
                    else{
                        $complianceRequest->status = $request->status;
                        
                        if($complianceRequest->save()){
                            return response([
                                'message' => "Status updated successfully!!!",
                                ],200);
                        }
                        else{
                            return response([
                                'message' => "Oops there is something wrong!!!",
                                ],500);
                        }
                    }
                }
                else{
                    return response([
                        'message' => "This compliance id does not have any compliance request mapped.",
                    ],422);
                }
            }
            else{
                return response([
                    'message' => "Not Authorized",
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



