<?php

namespace App\Models;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    // use SoftDeletes;

    public $table = 'jobs';

    protected $dates = [
        'hired_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'delivery_date',
    ];

    protected $fillable = ['user_id','job_type_id','job_expiry_date','department_id','designation_id','title','location_id','no_of_vacancy','minimum_exp_req','attachment','minimum_qualification','salary','location_preference','gender_preference','approved_by','description','status','created_at', 'updated_at', 'deleted_at'];

    public function designations() {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function job_type() {
        return $this->belongsTo(JobType::class, 'jobtype_id');
    }
    public function departments() {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function locations() {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function applied_job() {
        return $this->belongsTo(JobApplied::class, 'job_id');
    }
    public function employer(){
        return $this->belongsTo(User::class, 'employer_id');
    }
    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function proposals(){
        return $this->hasMany(Proposal::class, 'job_id');
    }
    public function getDeliveryDateAttribute($value){
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }
    public function setDeliveryDateAttribute($value){
        $this->attributes['delivery_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
    public function getHiredAtAttribute($value){
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }
    public function setHiredAtAttribute($value){
        $this->attributes['hired_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}