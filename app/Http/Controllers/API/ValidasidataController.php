<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Validasidata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidasidataController extends Controller
{
    public function getData(Request $request)
    {
        // Ambil input dengan nilai default jika tidak ada
        $search = $request->input('search', '');
        $perPage = $request->input('perPage', 10); // Default 10
        $sortField = $request->input('sortField', 'id'); // Default 'id'
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc'; // Default 'asc'
        $user = $request->user();

        // Validasi user
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Query data
        $data = Validasidata::where('status', 'Dikirim')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('opd', 'like', '%' . $search . '%')
                        ->orWhere('no_arsip', 'like', '%' . $search . '%')
                        ->orWhere('klasifikasi_arsip', 'like', '%' . $search . '%');
                });
            })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        try {
            $user = $request->user();
            $departments_id = $user->departments_id;

            $post_data = array_merge($validatedData, [
                "validator_id" => $departments_id,
            ]);

            $validasidata = Validasidata::updateOrCreate(
                ["id" => $request->id], // Menggunakan id untuk update atau create
                $post_data
            );

            return response()->json([
                "success" => true,
                "message" => "Berhasil menyimpan data!",
                "data" => $validasidata,
            ]);
        } catch (\Exception $e) {
            // Tangkap dan log error jika ada exception
            Log::error('Error pada penyimpanan data: ' . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan saat menyimpan data!",
            ], 500);
        }
    }

    public function getById($id)
    {
        $alihmedia = Validasidata::whereId($id)->first();

        return response()->json($alihmedia);
    }

    public function getImage($file)
    {
        $storagePath = storage_path('app/alihmedia/' . $file);

        if (is_file($storagePath)) {
            return response()->file($storagePath);
        } else {
            die("Tidak Dapat Menampilkan Data");
        }
    }
}