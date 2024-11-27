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

    public function register(Request $request){
        $validateData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'occupation' => 'required|in:Acompañamiento,Cuidado',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:caregivers,email',
            'password' => 'required|string|min:8',
        ]);

        $data = [
            'first_name' => $validateData['first_name'],
            'last_name' => $validateData['last_name'],
            'occupation' => $validateData['occupation'],
            'phone_number' => $validateData['phone_number'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']),
        ];

        $caregiver = Caregiver::create($data);

        return response()->json([
            'message' => 'Cuidador creado correctamente',
            'cuidador' => $caregiver,
        ], 201);
    }


    public function update(Request $request, $id){
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


    public function delete($id){
        $caregiver = Caregiver::find($id);
        if (!$caregiver) {
            return response()->json(['message' => 'Cuidador no encontrado o inexistente'], 404);
        }

        $caregiver->delete();
        return response()->json([
            'message'=>'Cuidador Eliminado Correctamente',
            'eliminado' => $caregiver
        ],200);
    }
}
