<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all user data from database and return it json
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $file = $request->file('document');
        $handle = fopen($file, 'r');

        $headers = fgetcsv($handle, 500, ';');
        $invalid_users = [];
        $valid_users = 0;

        while ($row = fgetcsv($handle, 500, ';')) {
            $user_data = array_combine($headers, $row);
            $validator = Validator::make($user_data, [
                'MANZANA Y VILLA' => 'required|string',
                'Identificacion' => 'required|string|unique:users,cedula',
                'Apellidos' => 'required|string',
                'Nombres' => 'required|string',
                'Estado_socio' => ['required', Rule::in(['Si', 'No'])],
                'Tipo_Usuario' => ['required', Rule::in(['0', '1'])],
            ]);

            if ($validator->fails()) {
                $invalid_users[] = [
                    'row_data' => $user_data,
                    'errors' => $validator->errors(),
                ];
            } else {
                $user = new User();
                $user->mv = $user_data['MANZANA Y VILLA'];
                $user->cedula = $user_data['Identificacion'];
                $user->name = strtoupper($user_data['Nombres']);
                $user->lastname = strtoupper($user_data['Apellidos']);
                $user->is_socio = ($user_data['Estado_socio'] == 'Si') ? 1 : 0;
                $user->role = $user_data['Tipo_Usuario'];
                $user->password = bcrypt($user_data['Identificacion']);
                $user->email_verified_at = now();
                $user->status = 5;
                $user->save();

                $valid_users++;
            }
        }

        fclose($handle);

        return response()->json([
            'success' => true,
            'total_valid_users' => $valid_users,
            'invalid_users' => $invalid_users,
            'total_invalid_users' => count($invalid_users),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $mv)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'required',
            'name' => 'required',
            'lastname' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('mv', $mv)->first();
        if (!$user) {
            return response()->json(['error' => 'El usuario no existe'], 422);
        }


        $user->cedula = $request->cedula;
        $user->name = strtoupper($request->name);
        $user->lastname = strtoupper($request->lastname);
        $user->phone = $request->phone;
        $user->emergency_phone = $request->emergency;
        if ($request->new_password != '') {
            $user->password = bcrypt($request->new_password);
        }
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => 'Usuario actualizado correctamente', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        // Change status to 0 to user is equal to $id
        $user = User::where('mv', $id)->first();
        if (!$user) {
            return response()->json(['error' => 'El usuario no existe'], 422);
        }

        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Usuario eliminado correctamente'], 200);
    }
}
