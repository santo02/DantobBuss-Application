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

    public function UpdateStatus($id)
    {
        $loket = loket::find($id);
        if ($loket) {
            $status = $loket->status;
            $loket->status = $status == 1 ? 0 : 1;
            $loket->save();
        }
    }
    public function getOne($id)
    {
        $loket = loket::find($id);
        if ($loket) {
            return response()->json(['data' => $loket, 'message' => 'Data Berhasil']);
        }
        return response()->json(['message' => 'Data not found']);
    }

    public function show()
    {
        $loket = DB::table('lokets')
            ->join('users', 'users.id', '=', 'lokets.admin_id')
            ->select('lokets.*', 'users.name', 'users.email')
            ->get();
        return response()->json($loket);
    }

    public function update($id)
    {
        $input = $this->validate(request(), [
            'nama_loket' => 'required|string',
            'lokasi_loket' => 'required|string',
            'admin_id' => 'required|integer|unique:lokets,admin_id,' . $id,
        ]);
        $loket = loket::find($id);
        if ($loket) {
            $loket->nama_loket = $input['nama_loket'];
            $loket->lokasi_loket = $input['lokasi_loket'];
            $loket->admin_id = $input['admin_id'];
            $loket->save();
        }
        return response()->json(['data' => $loket, 'message' => 'Data Berhasil']);
    }

    public function notAssociated()
    {
        $supir = DB::table('users')
            ->leftJoin('lokets', 'users.id', '=', 'lokets.admin_id')
            ->where('users.role_id', 4)
            ->whereNull('lokets.admin_id')
            ->select('users.*')
            ->get();


        return response()->json($supir);
    }
}
