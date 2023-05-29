<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{   
    use SoftDeletes;

    public $table="departments";
    
    protected $fillable = [ 'name', 'description','status','created_at','updated_at','deleted_at' ];

	    public function jobs() {
	        return $this->hasMany(Job::class);
	    }
}