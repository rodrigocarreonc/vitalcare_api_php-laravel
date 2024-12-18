<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';
    protected $primaryKey = 'id_patient';

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'id_patient');
    }
}
