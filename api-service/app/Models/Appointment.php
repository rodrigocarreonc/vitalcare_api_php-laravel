<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';
    protected $primaryKey = 'id_appointment';

    public function caregiver()
    {
        return $this->belongsTo(Caregiver::class, 'id_caregiver');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }
}
