<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EducationalLevel extends Model
{   
    use SoftDeletes;
    
    public $table="educational_levels";
    
        protected $fillable = [ 'name','status','created_at','updated_at','deleted_at' ];

	    public function jobs() {
	        return $this->hasMany(Job::class);
	    }
}
