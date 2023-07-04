<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLoketController extends Controller
{
    public function store(Request $request)
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
        $input['password'] = bcrypt('password');
        $input['photo'] = "null";
        $input['role_id'] = '4';
        $input['status'] = '1';

        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json([
            'data' => $success,
            'message' => 'Admin Loket berhasil didaftarkan!'
        ]);
    }

    public function index(){
        $user = User::where('role_id', 4)->get();

        return response()->json($user);
    }


}
