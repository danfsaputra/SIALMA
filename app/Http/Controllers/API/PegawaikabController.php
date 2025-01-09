<?php

namespace App\Http\Controllers\API;

use App\Models\Pegawaikab;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaikabStoreRequest as StoreRequest;
use Illuminate\Http\Request;

class PegawaikabController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Pegawaikab::when($search, function ($query) use ($search) {
            $query->where('nip', 'ilike', '%' . $search . '%')->orWhere('nama_lengkap', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

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

        // dd(date('Y/m/d', strtotime($request->tanggal_lahir)));
        Pegawaikab::updateOrCreate(["id" => $request->id], $post_data);

        // dd(($request->tanggal_lahir));

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function destroy($id)
    {
        Pegawaikab::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }
}
