<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Validasidata;
use Illuminate\Http\Request;

class ValidasidataController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';
        $user = $request->user();
        // $user_id = $user->role == 'Admin' ? '%' : $user->id;

        $data = Validasidata::where('status', 'Dikirim')
        // ->where('validator_id', 'ilike', $user_id)
        ->when($user->role !== 'Admin', function ($query) use ($user) {
            $query->where('user_id', $user->departments_id);
        })
            ->when($search, function ($query) use ($search) {
            $query->where('opd', 'ilike', '%' . $search . '%')
            ->orWhere('no_arsip', 'ilike', '%' . $search . '%')
            ->orWhere('klasifikasi_arsip', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store($request)
    {
        $user = $request->user();
        // $departments_id = $user->departments_id;

        // dd($departments_id);

        $post_data = array_merge($request->all(), [
            "validator_id" => $user->departments_id,
        ]);

        $alihmedia = Validasidata::updateOrCreate(["validator_id" => $request->departments_id], $post_data);

        dd($user);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !", "validator_id" => $alihmedia->departments_id]);
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
