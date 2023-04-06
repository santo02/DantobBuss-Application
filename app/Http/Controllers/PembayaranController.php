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

        // dd($request);
        $user = Auth::user();
        $currentDate = Carbon::now()->format('YmdHis');
        $validator = Validator::make($request->all(), [
            'schedules_id' => 'required|exists:schedules,id',
            'name' => 'required|string',
            'age' => 'required|string',
            'num_seats' => 'required|integer',
            // 'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $clientId = "BRN-0215-1665721005141";
        $requestId = '93626957-8ebe-4e0e-9778-3a1a623ea18b';
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $requestDate =  $dateTimeFinal;
        $targetPath = "/checkout/v1/payment"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
        $secretKey = "SK-3ut5p5VDAKku2Dqd541q";


        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->schedules_id = $request->schedules_id;
        $booking->name = $request->name;
        $booking->age = $request->age;
        $booking->alamatJemput = $request->alamatJemput;
        $booking->num_seats = $request->num_seats;
        $booking->status = 'booked';




        $requestBody = [
            "order" => [
                "amount" => intval($request->harga),
                "invoice_number" => "INV-EKBT-$currentDate",
                "currency" => "IDR",
                "callback_url" => "http://doku.com/",
                "callback_url_cancel" => "https://doku.com",
                "language" => "EN",
                "auto_redirect" => true,
                "disable_retry_payment" => true,
                "line_items" => [
                    [
                        "id" =>  $request->schedules_id,
                        "name" =>  "Pembelian Ticket E-KBT",
                        "quantity" => 1,
                        "price" => intval($request->harga),
                    ],
                ]
            ],
            "payment" => [
                "payment_due_date" => 60,
                "payment_method_types" => [
                    "VIRTUAL_ACCOUNT_BRI"
                ]
            ],
        ];

        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        $componentSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $requestDate . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digestValue;

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $dateTimeFinal,
            'Signature' => 'HMACSHA256=' . $signature,
        ])->post('https://api-sandbox.doku.com/checkout/v1/payment', $requestBody);

        $responseJson = json_decode($response->body());
        $httpCode = $response->status();

        $booking->save();
        $pembayaran = new Pembayaran;
        $pembayaran->schedules_id = $request->schedules_id;
        $pembayaran->bookings_id = $booking->id;
        $pembayaran->method = 'noncash';
        $pembayaran->status = 'menunggu';
        $pembayaran->date = Carbon::now();
        $pembayaran->original_request_id    = random_int(999, 99999);
        $pembayaran->transaksi_id = $booking->id + 100000;
        $pembayaran->terminal_id    = random_int(100, 999);
        $pembayaran->invoice_number     = "INV-EKBT-$currentDate";
        $pembayaran->amount    = intval($request->harga);
        $pembayaran->virtual_account_number = 000;
        $pembayaran->active = 000;
        $pembayaran->save();

        return response()->json([
            'data' => $responseJson,
            'code' => $httpCode,
        ]);
    }
}
