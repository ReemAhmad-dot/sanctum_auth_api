<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = "students";

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone_no"
    ];

    public $timestamps = false;
}
