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

        $invoice = "INV-EKBT-" . time();


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
        $booking->save();

        $pembayaran = new Pembayaran;
        $pembayaran->schedules_id = $request->schedules_id;
        $pembayaran->bookings_id = $booking->id;
        $pembayaran->method = 'cash';
        $pembayaran->status = 'Berhasil';
        $pembayaran->invoice_number     = $invoice;
        $pembayaran->created_date = time();
        $pembayaran->expired_date = "null";
        $pembayaran->how_to_pay_api = "null";
        $pembayaran->how_to_pay_page = "null";
        $pembayaran->amount    = $request->harga;
        $pembayaran->virtual_account_number = 'null';
        $pembayaran->active = 0;
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
            ->join('pembayarans', 'pembayarans.bookings_id', 'bookings.id')
            ->where('bookings.user_id', $user->id)
            // ->where('pembayarans.status', '=', 'Berhasil')
            ->select(
                'pembayarans.id as pembayarans_id',
                'bookings.id as bookings_id',
                'bookings.created_at',
                'schedules.id as schedule_id',
                'routes.derpature',
                'routes.arrival',
                'buses.nomor_pintu',
                'buses.type',
                'buses.number_of_seats',
                'schedules.tanggal',
                'users.name',
                'schedules.harga',
                'schedules.status',
                'pembayarans.status as status_pay',
                'pembayarans.how_to_pay_page',
                'pembayarans.how_to_pay_api',
                'pembayarans.created_date',
                'pembayarans.expired_date'
            )
            ->orderBy('bookings.created_at', 'DESC')
            ->get();


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
            ->whereIn('pembayarans.status', ['Berhasil', 'Menunggu'])
            ->select('bookings.*', 'schedules.id', 'routes.derpature', 'routes.arrival', 'buses.nomor_pintu', 'buses.type', 'buses.number_of_seats', 'schedules.tanggal', 'schedules.harga', 'schedules.status', 'pembayarans.method', 'pembayarans.status as status_pembayaran')
            ->get();


        $num_of_bookings = $booking->count();
        if ($booking) {
            return response()->json(['total' => $num_of_bookings, 'data' => $booking]);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }
    public function WaitPayment($id)
    {
        $wait = DB::table('bookings')
            ->join('schedules', 'bookings.schedules_id', 'schedules.id')
            ->join('buses', 'schedules.bus_id', 'buses.id')
            ->join('routes', 'schedules.route_id', 'routes.id')
            ->join('pembayarans', 'pembayarans.bookings_id', 'bookings.id')
            ->where('schedules.id', $id)
            ->where('pembayarans.status', 'Menunggu')
            ->select('bookings.*', 'schedules.id', 'routes.derpature', 'routes.arrival', 'buses.nomor_pintu', 'buses.type', 'buses.number_of_seats', 'schedules.tanggal', 'schedules.harga', 'schedules.status', 'pembayarans.method', 'pembayarans.status as status_pembayaran')
            ->get();

        $num_of_bookings = $wait->count();
        if ($wait) {
            return response()->json(['total' => $num_of_bookings, 'data' => $wait]);
        } else {
            return response()->json(['message' => 'Booking not found.'], 404);
        }
    }
    public function update($id)
    {
        $booking = Bookings::find($id);
        return $this->sendResponse($booking, 'Booking Retrieved Successfully');
    }

    public function expiredCheck($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran && $pembayaran != 'Expired') {
            return $this->sendResponse(null, 'Pembayaran Not Found');
        }
        $pembayaran->status = 'Expired';
        $pembayaran->save();
        return response()->json(['data' => $pembayaran, 'message' => 'update berhasil']);
    }
}
