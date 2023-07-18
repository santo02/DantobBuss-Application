<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DireksiController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;

        $keuangan = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('lokets', 'buses.loket_id', '=', 'lokets.id')
            ->select(DB::raw('DATE(schedules.tanggal) as tanggal'), DB::raw('SUM(schedules.harga) as total'))
            ->groupBy(DB::raw('DATE(schedules.tanggal)'))
            ->get();

        $total = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('lokets', 'buses.loket_id', '=', 'lokets.id')
            ->select(DB::raw('DATE(schedules.tanggal) as tanggal'), DB::raw('COUNT(DISTINCT buses.id) as jumlah'))
            ->groupBy(DB::raw('DATE(schedules.tanggal)'))
            ->get();


        return response()->json(['data' => $keuangan, 'total' => $total]);
    }

    public function getByTanggal(Request $request, $tanggal)
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->leftJoin('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.police_number', 'buses.nomor_pintu',  'routes.arrival', 'routes.derpature', 'routes.type', 'users.name', DB::raw('COUNT(bookings.schedules_id) as jumlah_booking'))
            ->whereDate('schedules.tanggal', '=', date('Y-m-d', strtotime($tanggal)))
            ->groupBy('schedules.id', 'schedules.tanggal', 'schedules.harga', 'buses.police_number', 'buses.nomor_pintu',  'routes.arrival', 'routes.derpature', 'routes.type', 'users.name',)
            ->get();

        return response()->json(['data' => $schedule]);
    }

    public function getPassenger($id)
    {
        $penumpang = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('schedules', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('pembayarans', 'bookings.id', 'pembayarans.bookings_id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->select('bookings.name', 'bookings.num_seats', 'bookings.number_phone', 'bookings.alamatJemput', 'pembayarans.method', 'routes.harga')
            ->where('bookings.schedules_id', '=', $id)
            ->get();

        return response()->json(['data' => $penumpang]);
    }
}
