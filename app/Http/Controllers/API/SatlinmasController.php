<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Satlinmas;
use Illuminate\Http\Request;

class SatlinmasController extends Controller
{
    public function getData(Request $request)
    {
    $perPage = $request->input('perPage', 10);
    $data = Satlinmas::paginate($perPage);

    // return response()->json([
    //     'data' => $data->items(),
    //     'total' => $data->total(),
    // ]);

    // dd($data);

    return response()->json($data);
    }
}
