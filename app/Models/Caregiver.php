<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id_caregiver';

    protected $hidden = ['password','created_at','updated_at'];

    protected $fillable = ['first_name','last_name','occupation','phone_number','email','password'];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }
}
