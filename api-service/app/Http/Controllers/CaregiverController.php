<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Caregiver;

class CaregiverController extends Controller
{
    public function index(){
        $caregivers = Caregiver::all();
        return response()->json($caregivers);
    }
}
