<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerdaStoreRequest;
use App\Models\Perda;
use Illuminate\Http\Request;

class PerdaController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Perda::when($search, function ($query) use ($search) {
            $query->where('perda', 'ilike', '%' . $search . '%')->orWhere('jenis_pelanggaran', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(PerdaStoreRequest $request)
    {
        $user = $request->user();
        $post_data = array_merge($request->all(), [
            // "created_by" => "1020",
            "created_by" => $user->id
        ]);

        Perda::updateOrCreate(["id" => $request->id], $post_data);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function destroy($id)
    {
        Perda::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }
}
