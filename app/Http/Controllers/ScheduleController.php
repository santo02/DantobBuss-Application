<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Bookings;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;
use Illuminate\Support\Facades\Validator;

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
    public function ShowALl()
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            // ->where('schedules.status', "!=", 'complete')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.status as status_bus', 'buses.nomor_pintu', 'buses.police_number', 'routes.status as routes_status', 'routes.derpature', 'routes.arrival', 'users.name')
            ->orderBy('schedules.tanggal', 'DESC')
            ->get();

        return response()->json(['data' => $schedule]);
    }
    public function index()
    {
        // $schedule = Schedule::with('buses.driver', 'routes')
        //     ->get();
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->where('schedules.status', "!=", 'complete')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->orderBy('schedules.tanggal', 'DESC')
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
            ->where('schedules.status', "!=", 'complete')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.status as status_bus', 'schedules.harga', 'buses.*', 'routes.*', 'users.name')
            ->get();

        $hasBooked = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.type', "=", 'Executive')
            ->select('bookings.schedules_id')
            ->get();

        return response()->json(['total' => $hasBooked, 'data' => $schedule]);
    }
    public function ShowEconomi()
    {
        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->where('schedules.status', "!=", 'complete')
            // ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->where('buses.type', '=', 'Economi')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.status as status_bus', 'schedules.harga',  'buses.*', 'routes.*', 'users.name')
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
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'schedules.bus_id', 'schedules.route_id', 'buses.*', 'routes.*', 'users.name')
            ->get();

        return $this->sendResponse($schedule, 'Schedule Retrieved Successfully');
    }
    // get by id supir

    public function getForSupir()
    {
        $user = Auth::user();

        $hasBooked = DB::table('schedules')
            ->join('bookings', 'bookings.schedules_id', '=', 'schedules.id')
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.type', "=", 'Economi')
            ->select('bookings.schedules_id')
            ->get();

        $schedule = DB::table('schedules')
            ->join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->join('routes', 'schedules.route_id', '=', 'routes.id')
            ->where('users.role_id', '=', 3)
            ->where('users.status', '=', 1)
            ->where('buses.status', '=', 1)
            ->where('routes.status', '=', 1)
            // ->where('schedules.status', 'complete')
            ->select('schedules.id as schedule_id', 'schedules.tanggal', 'schedules.harga', 'schedules.status as schedules_status', 'buses.*', 'routes.*', 'users.name')
            ->get();

        return response()->json(['total' => $hasBooked, 'data' => $schedule]);
    }
    public function update($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['message' => 'Route not found.'], 404);
        }
        $input = $this->validate(request(), [
            'tanggal' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'bus_id' => 'required|numeric|exists:buses,id',
            'route_id' => 'required|numeric|exists:routes,id',
            'status' => 'required|numeric|exists:schedules,status',
        ]);
        $schedule->update($input);
        return $this->sendResponse($schedule, 'Schedule Updated Successfully');
        
    }

    public function UpdateStatusBus($id)
    {
        $s = Schedule::find($id);
        if (!$s) {
            return response()->json(['message' => 'Route not found.'], 404);
        }
        if ($s->status == "not_started") {
            $s->status = "in_progress";
            $s->save();
        } elseif ($s->status == "in_progress") {
            $s->status = "complete";
            $s->save();
        } else {
            $s->status = "not_started";
            $s->save();
        }
        return $this->sendResponse($s, 'Satus has been update');
    }
}
