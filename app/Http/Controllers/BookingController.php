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
    public function store(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'schedules_id' => 'required|exists:schedules,id',
            'name' => 'required|string',
            'age' => 'required|string',
            'num_seats' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->schedules_id = $request->schedules_id;
        $booking->name = $request->name;
        $booking->age = $request->age;
        $booking->alamatJemput = $request->alamatJemput;
        $booking->num_seats = $request->num_seats;
        $booking->status = $request->status;
        $booking->save();

        return $this->sendResponse($booking, 'Bookings Successfully');
    }

    public function index()
    {
        // $booking = Bookings::with('schedules', 'user')->get();
        // $booking = Bookings::with('schedules', 'user')->all()->get();
        $booking = Bookings::with('schedules', 'user')->get();

        if ($booking) {
            return response()->json($booking);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }

    public function getOne($id)
    {
        $booking = Bookings::with('schedules', 'user')->where('id', $id)->get();

        if ($booking) {
            return response()->json($booking);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }
    public function getOneSchedules($id)
    {
        $booking = Bookings::with('schedules', 'user')->where('schedules_id', $id)->get();
        $num_of_bookings = $booking->count();
        if ($booking) {
            return response()->json(['total' => $num_of_bookings, 'data' => $booking]);
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
