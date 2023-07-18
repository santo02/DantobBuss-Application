<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LupaPasswordController extends Controller
{
    public function sendOTP(Request $request)
    {
        $email = $request->email;
        if ($user = User::where('email', $email)->first()) {
            $user->remember_token = strval(random_int(1000, 9999));
            $user->save();
            Mail::send('email.index', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email)->subject("Email Verification");
                $message->from('hello@example.com');
            });
            return response()->json(['message' => "Berhasil mengirim OTP "]);
        }
        return response()->json(['message' => "Email Tidak terdaftar "], 404);
    }
}
