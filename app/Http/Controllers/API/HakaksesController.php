<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hakakses;
use Illuminate\Http\Request;


class HakaksesController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Hakakses::where('hak_akses', 'like', '%' . $search . '%')
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }
}
