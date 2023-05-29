<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\kfupm_user;

class KFUPMApiController extends Controller
{
   
    public function getAllKfupmUser(Request $request)
    {   
        $key="fgfkhkudsghkjfgbkjflscxnjscbvkfgvkszdklcnmdklfjgirfgjkhgkj";
        if($request->key == $key){
        $KfupmUsers = kfupm_user::all();
        return $KfupmUsers;
        }else{
            return 'Unauthorised';
        }
    }
    
    
   
   
  
   
       
}
