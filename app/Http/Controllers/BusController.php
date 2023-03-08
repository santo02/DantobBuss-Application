<?php

namespace App\Http\Controllers;

use App\Models\bus;
use Illuminate\Http\Request;
use App\Http\Resources\Bus as BusResource;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusController extends BaseController
{
    public function store(Request $request)
    {

        $input = $this->validate($request, [
            'type' => 'required|string|max:20',
            'police_number' => 'required|string|unique:buses',
            'number_of_seats' => 'required|string',
            'merk' => 'required|string',
            'status' => 'required|string',
            'supir_id' => 'required:uniqe:users'
        ]);


        bus::create($input);

        return $this->sendResponse($input, 'Bus Created Successfully');
    }

    public function show()
    {
        $bus = DB::table('buses')
            ->join('users', 'buses.supir_id', '=', 'users.id')
            ->get();

        return $this->sendResponse(new BusResource($bus), 'Bus Retrieved Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator($input, [
            'type' => 'required|string',
            'police_number' => 'required|string|unique:buses',
            'number_of_seats' => 'required|string',
            'merk' => 'required|string',
            'status' => 'required|string',
            'supir_id' => 'required:uniqe:users'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $bus = bus::find($id);
        $bus->type = $request['type'];
        $bus->police_number = $request['police_number'];
        $bus->number_of_seats = $request['number_of_seats'];
        $bus->merk = $request['merk'];
        $bus->status = $request['status'];
        $bus->supir_id = $request['supir_id'];
        $bus->save();

        return $this->sendResponse($bus, 'Bus Updated Successfully');
    }

    public function delete($id)
    {
        $bus = bus::find($id);
        $bus->delete();
        return $this->sendResponse($bus->police_number, 'Bus Deleted Successfully');
    }
}
