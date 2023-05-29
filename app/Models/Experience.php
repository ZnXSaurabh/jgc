<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{

    public $table="experiences";
    protected $fillable = ['profile_id','level','vendors_user_id','designation', 'department','organisation','start_year','end_year','created_at','updated_at','deleted_at'];
}
