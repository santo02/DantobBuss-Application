<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

use Validator;

class RegisterUserController extends BaseController

{
    public function RegisterUser(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|unique:users',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'gender' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'

        ]);

        $input = $request->all();
        $input['password'] = bcrypt($fields['password']);
        $input['photo'] = "null";
        $input['role_id'] = '2';
        $input['status'] = 1;
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'register user berhasil!');
    }

    public function RegistrasiSupir(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $fields = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|string|unique:users',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'gender' => 'required|string',
        ]);

        $input = $request->all();
        $input['password'] = bcrypt('supir123');
        $input['photo'] = "null";
        $input['role_id'] = '3';
        $input['status'] = 1;
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json([
            'data' => $success,
            'message' => 'Supir  berhasil didaftarkan!'
        ]);
    }
}
