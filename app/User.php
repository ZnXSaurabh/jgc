<?php

namespace App;

use Hash;
use Carbon\Carbon;
use App\models\Country;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyUserNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $table = 'users';

    protected $fillable = [ 'name', 'email','phone','created_by', 'password','status','created_at', 'updated_at', 'deleted_at', 'remember_token', 'email_verified_at'];

    protected $hidden = [ 'password', 'remember_token'];

    protected $dates = [ 'updated_at', 'created_at', 'deleted_at', 'email_verified_at'];

    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    public function hasRole($role) {
        if ($this->roles()->where('title', $role)->first()) {
            return true;
        }
        return false;
    }
    
    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function applieduser() {
        return $this->hasMany('App\Models\JobApplied');
    }
    public function appliedCandidate() {
        return $this->hasMany('App\Models\JobApplied', 'candidate_id');
    }
    public function vendors() {
        return $this->hasMany('App\Models\Vendor');
    }

    public function profile(){
        return $this->hasOne('App\Models\Profile');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function isEmployer()
    {
        return $this->roles()->where('id', 2)->count() > 0;
    }

    public function isCandidate()
    {
        return $this->roles()->where('id', 3)->count() > 0;
    }
    public function token()
    {
        return $this->hasOne(UserToken::class);
    }

}
