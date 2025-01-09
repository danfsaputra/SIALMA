<?php

namespace App\Http\Controllers\API;

use App\Models\Sarpras;

use App\Http\Controllers\Controller;
use App\Http\Requests\SarprasStoreRequest as StoreRequest;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Sarpras::when($search, function ($query) use ($search) {
            $query->where('nama', 'ilike', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(StoreRequest $request)
    {
        $user = $request->user();

        $post_data = array_merge($request->all(), [
            "user_id" => $user->id,
        ]);

        Sarpras::updateOrCreate(['id' => $request->id], $post_data);

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function destroy($id)
    {
        Sarpras::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }
}
