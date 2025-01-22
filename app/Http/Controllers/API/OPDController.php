<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OPD; // Sesuaikan dengan nama model OPD Anda
use Illuminate\Http\Request;

class OPDController extends Controller
{
    public function getOPDList(Request $request)
    {
        // Ambil parameter dari request jika ada
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user(); // Mendapatkan informasi pengguna yang sedang login

        // Query untuk mengambil data OPD
        $opds = OPD::when($user->role !== 'Admin', function ($query) use ($user) {
                $query->where('department_id', $user->departments_id); // Menyaring data berdasarkan department pengguna jika bukan Admin
            })
            ->when($search, function ($query) use ($search) {
                // Menyaring data berdasarkan pencarian
                $query->where('name', 'ilike', '%' . $search . '%')
                      ->orWhere('description', 'ilike', '%' . $search . '%'); // Menyesuaikan kolom pencarian
            })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                // Menyortir data jika parameter sortField ada
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        // Kembalikan data dalam format JSON
        return response()->json($opds);
    }
}
