<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Pembayaran;
use App\Utils\SignatureDoku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DOKU\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public static function generateToken(Request $request)
    {

        $user = Auth::user();
        $currentDate = Carbon::now()->format('YmdHis');
        $validator = Validator::make($request->all(), [
            'schedules_id' => 'required|exists:schedules,id',
            'name' => 'required|string',
            'number_phone' => 'required|string',
            'num_seats' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        $testid = substr($uuid, 0, 32);
        $clientId = "BRN-0215-1665721005141";
        $requestId = $testid;
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $requestDate =  $dateTimeFinal;
        $targetPath = "/mandiri-virtual-account/v2/payment-code"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
        $secretKey = "SK-3ut5p5VDAKku2Dqd541q";

        $requestBody = [
            "order" => [
                "invoice_number" => "INV-EKBT-" . time(),
                "amount" => 20000
            ],
            "virtual_account_info" => [
                "billing_type" => "FIX_BILL",
                "expired_time" => 60,
                "reusable_status" => false,
                "info1" => "Merchant Demo Store",
                "info2" => "Thank you for shopping",
                "info3" => "on our store"
            ],
            "customer" => [
                "name" => "test payment",
                "email" => "anton@example.com"
            ]

        ];

        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        $componentSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $dateTimeFinal . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digestValue;

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $dateTimeFinal,
            'Signature' => 'HMACSHA256=' . $signature,
        ])->post('https://api-sandbox.doku.com/mandiri-virtual-account/v2/payment-code', $requestBody);

        $responseJson = json_decode($response->body());
        $httpCode = $response->status();

        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->schedules_id = $request->schedules_id;
        $booking->name = $request->name;
        $booking->number_phone = $request->number_phone;
        $booking->alamatJemput = $request->alamatJemput;
        $booking->num_seats = $request->num_seats;
        $booking->status = 'booked';

        $booking->save();
        $pembayaran = new Pembayaran;
        $pembayaran->schedules_id = $request->schedules_id;
        $pembayaran->bookings_id = $booking->id;
        $pembayaran->method = 'noncash';
        $pembayaran->status = 'Menunggu';
        $pembayaran->date = Carbon::now();
        $pembayaran->original_request_id = random_int(999, 99999);
        $pembayaran->transaksi_id = $booking->id + 100000;
        $pembayaran->terminal_id = random_int(100, 999);
        $pembayaran->invoice_number = "INV-EKBT-$currentDate";
        $pembayaran->amount    = $request->harga;
        $pembayaran->virtual_account_number = 000;
        $pembayaran->active = 000;
        $pembayaran->save();

        return response()->json([
            'data' => $responseJson,
            'code' => $httpCode,
        ]);
    }
}
