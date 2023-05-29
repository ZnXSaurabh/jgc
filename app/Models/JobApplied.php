<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplied extends Model
{
    use SoftDeletes;
    public $table="job_applieds";

    protected $fillable = [ 'job_id', 'candidate_id','status', 'applied_by','applied_date','created_at', 'updated_at', 'deleted_at' ];

    public function users() {
        return $this->belongsTo('App\User', 'candidate_id');
    }
}
