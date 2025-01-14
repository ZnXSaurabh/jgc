<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    
    public $table   = "educations";

    protected $fillable = ['profile_id','level','vendors_user_id', 'course', 'university','percentage','start_year','end_year','created_at','updated_at','deleted_at'];
}
