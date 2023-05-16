<?php

namespace App\Http\Controllers;

use App\Models\loket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoketController extends Controller
{

    public function store(Request $request)
    {

        $input = $this->validate($request, [
            'nama_loket' => 'required|string',
            'lokasi_loket' => 'required|string',
            'admin_id' => 'required|integer|unique:lokets',
        ]);


        loket::create($input);

        return response()->json(['data' => $input, 'message' => 'Loet  Successfully added']);
    }

    public function show()
    {
        $loket = DB::table('lokets')
            ->join('users', 'users.id', '=', 'lokets.admin_id')
            ->select('lokets.*', 'users.name', 'users.email')
            ->get();
        return response()->json($loket);
    }
}
