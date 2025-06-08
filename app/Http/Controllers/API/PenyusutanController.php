<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penyusutan;
use App\Http\Requests\PenyusutanStoreRequest as StoreRequest;
use Illuminate\Http\Request;


class PenyusutanController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Penyusutan::where('nm_penyusutan_akhir', 'like', '%' . $search . '%')
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

        $penyusutan = Penyusutan::updateOrCreate(
            ['id' => $id], 
            $request->validated() 
        );

        return response()->json([
            'success' => true,
            'message' => $id ? 'Data Penyusustan berhasil diperbarui!' : 'Data Penyusutan berhasil dibuat!',
            'data' => $penyusutan,
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
            $penyusutan = Penyusutan::findOrFail($id);
            return response()->json($penyusutan);
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
            $penyusutan = Penyusutan::findOrFail($id);
            $penyusutan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Penyusutan berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data!',
            ], 500);
        }
    }
}
