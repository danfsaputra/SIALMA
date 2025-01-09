<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function getData(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $data = Pelanggaran::with('refmodul')->paginate($perPage);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
        ]);
    }
}
