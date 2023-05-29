<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use SoftDeletes;

    public $table="designations";

    protected $fillable = [ 'name', 'description','status','created_at','updated_at','deleted_at' ];

    public function SimilarDesignation() {
        return $this->hasMany('App\Models\Job');
    }
}
