<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    use HasFactory;

    protected $hidden = ['password','created_at','updated_at'];

    protected $fillable = ['first_name','last_name','occupation','phone_number','email','password'];
}