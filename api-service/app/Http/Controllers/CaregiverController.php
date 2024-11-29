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

    public function updateProfile(Request $request){
        $id = auth()->user()->id_caregiver;

        $caregiver = Caregiver::find($id);

        if (!$caregiver) {
            return response()->json(['message' => 'Cuidador no encontrado o inexistente'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:150',
            'occupation' => 'sometimes|in:Acompañamiento,Cuidado',
            'phone_number' => 'sometimes|string|max:15',
            'email' => 'sometimes|email|unique:caregivers,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $caregiver->update($validatedData);

        return response()->json([
            'message' => 'Cuidador actualizado correctamente',
            'cuidador' => $caregiver,
        ], 200);
    }

    public function appointments(){
        $id = auth()->user()->id_caregiver;
        $appointment = Caregiver::join('appointment','caregivers.id_caregiver','=','appointment.id_caregiver')
        ->where('caregivers.id_caregiver',$id)
        ->select('cause','date')->get();
        return response()->json($appointment);
    }
}
