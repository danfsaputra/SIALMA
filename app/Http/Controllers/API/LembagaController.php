<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    // public function getData(Request $request)
    // {
    //     $data = Lembaga::all();
    //     return response()->json($data);
    // }

    public function getData(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $data = Lembaga::paginate($perPage);

        return response()->json([
            'data' => $data->items(),
        ]);

        // dd();
    }
}

