<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Caregiver extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $primaryKey = 'id_caregiver';

    protected $fillable = ['first_name','last_name','occupation','phone_number','email','password'];

    protected $hidden = ['password','created_at','updated_at'];


    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'id_caregiver');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
