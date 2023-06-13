<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Bookings;
use App\Models\bus;
use App\Models\Pembayaran;
use App\Models\Routes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{
    public function store(Request $request)
    {

        $user = Auth::user();
        $currentDate = Carbon::now()->format('Ymd');
        $validator = Validator::make($request->all(), [
            'schedules_id' => 'required|exists:schedules,id',
            'name' => 'required|string',
            'number_phone' => 'required|string',
            'num_seats' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->schedules_id = $request->schedules_id;
        $booking->name = $request->name;
        $booking->number_phone = $request->number_phone;
        $booking->alamatJemput = $request->alamatJemput;
        $booking->num_seats = $request->num_seats;
        $booking->status = "menunggu";
        $booking->save();

        $pembayaran = new Pembayaran;
        $pembayaran->schedules_id = $request->schedules_id;
        $pembayaran->bookings_id = $booking->id;
        $pembayaran->method = 'cash';
        $pembayaran->status = 'berhasil';
        $pembayaran->date = Carbon::now();
        $pembayaran->original_request_id    = random_int(100, 9999);
        $pembayaran->transaksi_id = $booking->id + 100000;
        $pembayaran->terminal_id    = random_int(100, 999);
        $pembayaran->invoice_number     = "INV-$currentDate";
        $pembayaran->amount    = 10000;
        $pembayaran->virtual_account_number    = 000;
        $pembayaran->active = 000;
        $pembayaran->save();



        if ($booking->save() && $pembayaran->save()) {
            return response()->json([
                'bookings' => $booking,
                'pembayaran' => $pembayaran,
                'message' => 'berhasil'
            ]);
        }
        return 'gagal';
    }

    public function index()
    {
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

    public function getByUserId()
    {
        $user = Auth::user();
        
        $booking = DB::table('bookings')
            ->join('schedules', 'bookings.schedules_id', 'schedules.id')
            ->join('buses', 'schedules.bus_id', 'buses.id')
            ->join('users', 'buses.supir_id', 'users.id')
            ->join('routes', 'schedules.route_id', 'routes.id')
            ->where('bookings.user_id', $user->id)
            ->select('bookings.id as bookings_id','bookings.created_at','schedules.id as schedule_id','routes.derpature','routes.arrival', 'buses.nomor_pintu', 'buses.type', 'buses.number_of_seats', 'schedules.tanggal', 'users.name', 'schedules.harga', 'schedules.status')
            ->orderBy('bookings.created_at', 'DESC')
            ->get();
        // $booking = Bookings::with('schedules', 'user', 'buss')->where('user_id', $user->id)->get();
        if ($booking) {
            return response()->json($booking);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }

    public function getOneSchedules($id)
    {
        $booking = DB::table('bookings')
        ->join('schedules', 'bookings.schedules_id', 'schedules.id')
        ->join('buses', 'schedules.bus_id', 'buses.id')
        ->join('routes', 'schedules.route_id', 'routes.id')
        ->join('pembayarans', 'pembayarans.bookings_id', 'bookings.id')
        ->where('schedules.id', $id)
        ->select('bookings.*','schedules.id','routes.derpature','routes.arrival', 'buses.nomor_pintu', 'buses.type', 'buses.number_of_seats', 'schedules.tanggal', 'schedules.harga', 'schedules.status', 'pembayarans.method')
        ->get();

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
