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

    //Update
    public function update(Request $request, $id){
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'occupation' => 'sometimes|required|in:Acompañamiento,Cuidado',
            'phone_number' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|email|unique:caregivers,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        $caregiver = Caregiver::find($id);

        if(!$caregiver){
            return response()->json([
                'message'=> 'Cuidador no encontrado o inexistente',
            ],404);
        }

        $caregiver->update([
            'first_name' => $validatedData['first_name'] ?? $caregiver->first_name,
            'last_name' => $validatedData['last_name'] ?? $caregiver->last_name,
            'occupation' => $validatedData['occupation'] ?? $caregiver->occupation,
            'phone_number' => $validatedData['phone_number'] ?? $caregiver->phone_number,
            'email' => $validatedData['email'] ?? $caregiver->email,
            'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $caregiver->password,
        ]);

        return response()->json([
            'message'=>'Cuidador actualizado correctamente',
            'cuidador' => $caregiver,
        ],200);
    }

    public function delete($id){
        $caregiver = Caregiver::find($id);

        if(!$caregiver){
            return response()->json([
                'message' => 'Cuidador no encontrado o inexistente',
            ],404);
        }

        $caregiver->delete();

        return response()->json([
            'message'=>'Cuidador eliminado exitosamente',
        ],200);
    }
}
