<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Keamanan;
use App\Http\Requests\KeamananStoreRequest as StoreRequest;
use Illuminate\Http\Request;


class KeamananController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Keamanan::where('klas_keamanan', 'like', '%' . $search . '%')
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

        $keamanan = Keamanan::updateOrCreate(
            ['id' => $id], 
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => $id ? 'Data klasifikasi Keamanan berhasil diperbarui!' : 'Data klasifikasi Keamanan berhasil dibuat!',
            'data' => $keamanan,
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
            $keamanan = Keamanan::findOrFail($id);
            return response()->json($keamanan);
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
            $keamanan = Keamanan::findOrFail($id);
            $keamanan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Klasifikasi Keamanan berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}
