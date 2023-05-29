<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
   	
   
   	public $table='profiles';

   	protected $fillable = ['user_id','address','address2','gender','country','city','state','zip_code','resume','dob','profile_pic','about','created_at','emp_no','updated_at','deleted_at'];

   	public function user() {
      return $this->belongsTo('App\User', 'user_id');
  	}

  	public function columnCount()
  	{
  		$percent = count(array_filter($this->attributes)) / count($this->attributes)-4 * 100;
    	// dd($percent);
	}
}