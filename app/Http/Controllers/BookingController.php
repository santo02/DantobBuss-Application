<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date_format:Y-m-d H:i:s',
            'arrival_date' => 'required|date_format:Y-m-d H:i:s',
            'passenger_name' => 'required',
            'passenger_email' => 'required|email',
            'passenger_phone' => 'required',
            'seat_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $booking = new Bookings;
        $booking->user_id = $request->user_id;
        $booking->bus_id = $request->bus_id;
        $booking->route_id = $request->route_id;
        $booking->departure_date = $request->departure_date;
        $booking->arrival_date = $request->arrival_date;
        $booking->passenger_name = $request->passenger_name;
        $booking->passenger_email = $request->passenger_email;
        $booking->passenger_phone = $request->passenger_phone;
        $booking->seat_number = $request->seat_number;
        $booking->save();

        return response()->json(['message' => 'Booking created successfully.'], 201);
    }
}
