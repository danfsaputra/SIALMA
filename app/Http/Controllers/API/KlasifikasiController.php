<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Klasifikasi;
use App\Http\Requests\KlasifikasiStoreRequest as StoreRequest;
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

        $data = Klasifikasi::where('nm_klasifikasi', 'like', '%' . $search . '%')
            ->when($search, function ($query) use ($search) {
                $query->where('nm_klasifikasi', 'like', '%' . $search . '%')
                    ->orWhere('hak_akses', 'like', '%' . $search . '%')
                    ->orWhere('penyusutan_akhir', 'like', '%' . $search . '%');
            })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(StoreRequest $request)
{
    try {
        $id = $request->input('id');

        $klasifikasi = Klasifikasi::updateOrCreate(
            ['id' => $id], 
            $request->validated() 
        );

        return response()->json([
            'success' => true,
            'message' => $id ? 'Data klasifikasi berhasil diperbarui!' : 'Data klasifikasi berhasil dibuat!',
            'data' => $klasifikasi,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data!',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function getById($id)
    {
        try {
            $klasifikasi = Klasifikasi::findOrFail($id);
            return response()->json($klasifikasi);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $klasifikasi = Klasifikasi::findOrFail($id);
            $klasifikasi->forcedelete();

            return response()->json([
                'success' => true,
                'message' => 'klasifikasi berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}