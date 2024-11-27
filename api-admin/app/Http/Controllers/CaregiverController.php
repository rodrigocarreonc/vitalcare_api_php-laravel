<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Caregiver;

class CaregiverController extends Controller
{
    public function all(){
        $caregivers = Caregiver::all();
        return response()->json($caregivers);
    }

    public function get($id){
        $caregiver = Caregiver::where('id_caregiver',$id)->get();
        return response()->json($caregiver);
    }
}
