<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jenisarsip;
use Illuminate\Http\Request;
use App\Http\Requests\JenisarsipStoreRequest as StoreRequest;


class JenisarsipController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Jenisarsip::where('nm_arsip', 'like', '%' . $search . '%')
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

        $jenisarsip = Jenisarsip::updateOrCreate(
            ['id' => $id], 
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => $id ? 'Data jenis arsip berhasil diperbarui!' : 'Data jenis arsip berhasil dibuat!',
            'data' => $jenisarsip,
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
            $jenisarsip = Jenisarsip::findOrFail($id);
            return response()->json($jenisarsip);
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
            $jenisarsip = Jenisarsip::findOrFail($id);
            $jenisarsip->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jenis Arsip berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}
