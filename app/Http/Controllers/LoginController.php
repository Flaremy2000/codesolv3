<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function logout(Request $request)
    {
        $userdata = json_decode($request->header('X-User-Data'));
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Change is_online to 0  when user is logged out
        $user = User::where('id_user', $userdata->id_user)->first();
        $user->is_online = 0;
        $user->update();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function login(Request $request)
    {

        $credentials = [
            'mv' => $request->username,
            'password' => $request->password,
            'status' => '1'
        ];

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            // Change is_online to 1  when user is logged in
            $user = User::where('mv', $request->username)->first();
            $user->is_online = 1;
            $user->update();
            return response()->json(['user' => Auth::user()], 200)->cookie('laravel_session', json_encode(Auth::user()));
        } else {
            $user = User::where('mv', $request->username)->first();
            if ($user) {
                if ($user->status == 5) {
                    return response()->json(['redirect' => '/cambiar_contraseña', 'id_user' => $user->id_user], 200);
                    // return response()->json(['error' => 'User is inactive'], 401);
                }
            }

        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Change password when user is inactive (status = 5)
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Change status to 1 when user changes password
        $user = User::where('id_user', $request->id_user)->first();
        $user->password = bcrypt($request->password);
        $user->status = 1;
        $user->update();

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }
}
