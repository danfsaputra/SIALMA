<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\KasusStoreRequest as StoreRequest;

use App\Http\Controllers\Controller;
use App\Models\Kasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Kasus::when($search, function ($query) use ($search) {
            $query->where('nama_pelanggar', 'ilike', '%' . $search . '%')
                ->orWhere('lokasi_kejadian', 'ilike', '%' . $search . '%')
                ->orWhere('kel_nama', 'ilike', '%' . $search . '%');
        })->when($sortField, function ($query) use ($sortField, $sortOrder) {
            $query->orderBy($sortField, $sortOrder);
        })->paginate($perPage);

        return response()->json($data);
    }

    public function store(StoreRequest $request)
    {
        $user = $request->user();
        $post_data = array_merge($request->all(), [
            "jenis_jabatan" => "Pelaksana",
            "unit_kerja" => "SATUAN POLISI PAMONG PRAJA",
            "kab_kota_id" => "22",
            "userid" => $user->id
        ]);

        Kasus::updateOrCreate(["id" => $request->id], $post_data);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function destroy($id)
    {
        Kasus::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }
}
