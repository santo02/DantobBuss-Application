<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DokuController extends Controller
{

    public function notifications(Request $request)
    {
        try {
            $notificationHeader = getallheaders();
            $notificationBody = file_get_contents('php://input');
            $notificationPath = '/api/payments/notifications'; // Adjust according to your notification path
            $secretKey = "SK-3ut5p5VDAKku2Dqd541q"; // Adjust according to your secret key

            $digest = base64_encode(hash('sha256', $notificationBody, true));
            $rawSignature = "Client-Id:" . $notificationHeader['Client-Id'] . "\n"
                . "Request-Id:" . $notificationHeader['Request-Id'] . "\n"
                . "Request-Timestamp:" . $notificationHeader['Request-Timestamp'] . "\n"
                . "Request-Target:" . $notificationPath . "\n"
                . "Digest:" . $digest;

            $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));
            $finalSignature = 'HMACSHA256=' . $signature;

            if ($finalSignature == $notificationHeader['Signature']) {

                $decodedBody = json_decode($notificationBody, true);

                $transaction = Pembayaran::where("invoice_number", $decodedBody['order']['invoice_number'])->with(['user:id,name,uuid'])->first();

                if ($transaction) {
                    $transaction->status = 'Berhasil';  
                    $transaction->save();

                } else {
                    return response('Not Found', 404)->header('Content-Type', 'text/plain');
                }
                return response('OK', 200)->header('Content-Type', 'text/plain');
            } else {
                // TODO: Response with 400 errors for Invalid Signature
                return response('Invalid Signature', 400)->header('Content-Type', 'text/plain');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }
}
