<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Daftararsip;
use Illuminate\Http\Request;

class DaftararsipController extends Controller
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
        $data = Daftararsip::where('status', 'Disetujui')
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
        $user = $request->user();
        $departments_id = $user->departments_id;

        $post_data = array_merge($request->all(), [
            "validator_id" => $user->departments_id,
        ]);

        $alihmedia = Daftararsip::updateOrCreate(["validator_id" => $request->departments_id], $post_data);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !", "validator_id" => $alihmedia->departments_id]);
    }

    public function getById($id)
    {
        $alihmedia = Daftararsip::whereId($id)->first();

        return response()->json($alihmedia);
    }

    public function getImage($file)
    {
        $storagePath = storage_path('app/alihmedia/' . $file);

        if (is_file($storagePath)) {
            return response()->file($storagePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}