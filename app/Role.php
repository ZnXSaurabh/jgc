<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users() {
        return $this->belongsToMany('App\User', 'user_role', 'role_id', 'user_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Models\Permission::class);
    }
}
