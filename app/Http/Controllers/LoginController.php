<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Validator;

class LoginController extends BaseController
{
  public function login(Request $request)
  {

    $fields = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);
    if (Auth::attempt($fields)) {
      $accessToken = Auth::user()->createToken('authToken')->accessToken;

      return response()->json([
        'access_token' => $accessToken,
        'token_type' => 'Bearer',
        'expires_at' => now()->addDays(7),
      ]);
    }
    return response()->json(['message' => 'Invalid credentials'], 401);
  }

  
  public function user(Request $request)
  {
    return response()->json($request->user());
  }

  public function logout(Request $request)
  {
    $request->user()->token()->revoke();

    return response()->json(['message' => 'Successfully logged out']);
  }
}
