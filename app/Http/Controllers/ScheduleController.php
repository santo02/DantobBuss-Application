<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Bookings;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class ScheduleController extends BaseController
{
    public function store(Request $request)
    {
        $input = $this->validate($request, [
            'bus_id' => 'required',
            'route_id' => 'required',
            'tanggal' => 'required|date',
            'harga' => 'required|string',
            // 'status' => 'not_started',
        ]);
        $input['status'] = 'not_started';
        Schedule::create($input);

        return $this->sendResponse($input, 'Schedule Created Successfully');
    }

    public function index()
    {
        // $schedule = Schedule::with('buses.driver', 'routes')
        //     ->get();
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        // return $this->sendResponse($schedule, 'Schedule Retrieved Successfully');

        $hasBooked = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            // ->where('buses.type', "=", 'Economi')
            ->select('bookings.schedules_id')
            ->get();

        return response()->json(['total' => $hasBooked, 'data' => $schedule]);
    }
    public function ShowExecutive()
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->where('buses.type', '=', 'Executive')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        $hasBooked = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->where('buses.type', '=', 'Executive')
            ->select('bookings.num_seats', 'schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->count();

        return response()->json(['total' => $hasBooked, 'data' => $schedule]);
    }
    public function ShowEconomi()
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            // ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->where('buses.type', '=', 'Economi')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        $hasBooked = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.type', "=", 'Economi')
            ->select('bookings.schedules_id')
            ->get();

        return response()->json(['total' => $hasBooked, 'data' => $schedule]);
    }
    //get by id schedule
    public function SelectOne($id)
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            // ->where('buses.type', '=', 'Ekonomi')
            ->where('schedules.id', '=', $id)
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        return $this->sendResponse($schedule, 'Schedule Retrieved Successfully');
    }
    // get by id supir

    public function getForSupir()
    {
        $user = Auth::user();

        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->where('users.role_id', '=', 3)
            ->where('users.id', '=', $user->id)
            // ->where('schedules.status', 'complete')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        return response()->json(['data' => $schedule]);
    }
}
