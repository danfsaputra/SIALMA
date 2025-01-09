<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Klasifikasi;
use Illuminate\Http\Request;

class KlasifikasiController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Klasifikasi::when($user->role !== 'Admin', function ($query) use ($user) {
            $query->where('user_id', $user->departments_id);
        })
            ->when($search, function ($query) use ($search) {
            $query->where('nm_klasifikasi', 'ilike', '%' . $search . '%')
            ->orWhere('hak_akses', 'ilike', '%' . $search . '%')
            ->orWhere('penyusutan_akhir', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }
}
