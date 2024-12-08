<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Caregiver;
use App\Models\Appointment;

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
        $appointment = Appointment::where('id_caregiver', $id)
        ->with(['patient:id_patient,first_name,last_name']) // Carga el paciente asociado (id y nombre)
        ->get(['id_patient','cause', 'date'])
        ->map(function ($appointment) {
            return [
                'patient_name' => $appointment->patient->first_name ?? 'N/A',
                'patient_lastname' => $appointment->patient->last_name ?? 'N/A',
                'cause' => $appointment->cause,
                'date' => $appointment->date,
            ];
        });
        return response()->json($appointment);
    }

    public function addAppointment(Request $request){
        $validateData = $request->validate([
            'cause' => 'required|string|max:100',
            'date' => 'required|date',
            'id_caregiver' => 'required|int',
            'id_patient' => 'required|int'
        ]);

        $data = [
            'cause' => $validateData['cause'],
            'date' => $validateData['date'],
            'id_caregiver' => $validateData['id_caregiver'],
            'id_patient' => $validateData['id_patient']
        ];

        $appointment = Appointment::create($data);

        return response()->json([
            'message' => "Cita Creada Con Exito!",
            'appointment' => $appointment, 
        ],200);
    }
}
