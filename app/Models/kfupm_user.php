<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kfupm_user extends Model
{
    public $table="kfupm_users";

    protected $fillable = ['name'];
    
    public $timestamp = "false";
}
