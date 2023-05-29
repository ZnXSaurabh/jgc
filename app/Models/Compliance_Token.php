<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance_Token extends Model
{
    use HasFactory;

    public $table = 'compliance_token';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'fullname',
        'email',
        'token',
    ];
}
