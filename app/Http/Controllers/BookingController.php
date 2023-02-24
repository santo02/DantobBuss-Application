<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Bookings;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{
    public function store(Request $request, $id_bus)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'num_seats' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->bus_id = $id_bus;
        $booking->route_id = $request->route_id;
        $booking->departure_time = $request->departure_time;
        $booking->num_seats = $request->num_seats;
        $booking->save();

        return $this->sendResponse($booking, 'Bookings Successfully');
    }

    public function index()
    {
        $booking = Bookings::with('route', 'bus', 'user')->all();
    
        if ($booking) {
            return response()->json($booking);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }

    public function show($id)
    {
        $booking = Bookings::with('route', 'bus', 'user')->find($id);
    
        if ($booking) {
            return response()->json($booking);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }
    public function update($id)
    {
        $booking = Bookings::find($id);

        
        return $this->sendResponse($booking, 'Booking Retrieved Successfully');
        
    }
}
