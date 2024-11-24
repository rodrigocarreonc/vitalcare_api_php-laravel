<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Models\Caregiver;

class CaregiverController extends Controller
{
    public function all(){
        $caregivers = Caregiver::all();
        return response()->json($caregivers);
    }

    //Create
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'occupation' => 'required|in:Acompañamiento,Cuidado',
                'phone_number' => 'required|string|max:15',
                'email' => 'required|email|unique:caregivers,email',
                'password' => 'required|string|min:8',
            ]);

            $caregiver = Caregiver::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'occupation' => $validatedData['occupation'],
                'phone_number' => $validatedData['phone_number'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return response()->json([
                'message' => 'Cuidador creado con éxito.',
                'cuidador' => $caregiver,
            ], 201);

        } catch (ValidationException $e) {
            // Captura errores de validación y personaliza la respuesta
            return response()->json([
                'message' => 'Error al crear cuidador.',
                'errors' => $e->errors(), // Devuelve los errores específicos
            ], 422);
        }
    }
}
