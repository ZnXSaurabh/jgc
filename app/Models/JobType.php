<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends Model
{
    use SoftDeletes;
    public $table="job_types";

    protected $fillable = [ 'job_type', 'description','status','created_at', 'updated_at', 'deleted_at' ];
    
    public function jobs() {
        return $this->hasMany(Job::class);
    }
}
