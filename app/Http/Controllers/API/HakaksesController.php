<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hakakses;
use App\Http\Requests\HakaksesStoreRequest as StoreRequest;
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

    public function store(StoreRequest $request)
{
    try {
        $id = $request->input('id');

        $hakakses = Hakakses::updateOrCreate(
            ['id' => $id], 
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => $id ? 'Data Hak Akses berhasil diperbarui!' : 'Data Hak Akses berhasil dibuat!',
            'data' => $hakakses,
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
        $hakakses = Hakakses::findOrFail($id); 
        return response()->json($hakakses);
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
            $hakakses = Hakakses::findOrFail($id);
            $hakakses->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hak Akses berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}
