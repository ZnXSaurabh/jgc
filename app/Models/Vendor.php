<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{   
    

    public $table="vendors";

    protected $fillable = ['vendor_reg_no','status','vendor_service_id_no','user_id','country','city','state','zip_code','dob','created_at','updated_at','deleted_at'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
