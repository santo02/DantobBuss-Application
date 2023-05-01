<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Routes;

class RoutesController extends BaseController
{
    public function index(Request $request){
        $routes = Routes::all();
        return $this->sendResponse($routes, 'Routes Retrieved Successfully');

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'derpature' => 'required|string',
            'arrival' => 'required|string',
            'harga' => 'required|string',
            'type' => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        $routes = new Routes;

        $routes->derpature = $request->derpature;
        $routes->arrival = $request->arrival;
        $routes->harga = $request->harga;
        $routes->type = $request->type;
        $routes->save();

        return $this->sendResponse($routes, 'Routes Created Successfully');
    }

    public function update(Request $request, $id)
    {
        $routes = Routes::find($id);
        if (!$routes) {
            return response()->json(['message' => 'Route not found.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'derpature' => 'required|string',
            'arrival' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $routes->derpature = $request->derpature;
        $routes->arrival = $request->arrival;
        $routes->save();
        return $this->sendResponse($routes, 'Routes Created Successfully');
    }

    public function destroy($id){
        $routes = Routes::find($id);

        if (!$routes) {
            return response()->json(['message' => 'Routes not found.'], 404);
        }

        $routes->delete();
        return $this->sendResponse($routes,'Bus Deleted Successfully');
    }
}
