<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorsCandidates extends Model
{
    public $table = 'vendors_candidates';

    protected $fillable = [ 'name', 'email','phone','created_by', 'password','status','address','address2','gender','country','city','state','zip_code','resume','dob','profile_pic','about','created_at','emp_no','updated_at','deleted_at'];
}
