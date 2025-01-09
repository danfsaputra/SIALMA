<?php

namespace App\Http\Controllers\API;

use App\Models\Kegiatan;

use App\Http\Controllers\Controller;
use App\Http\Requests\KegiatanStoreRequest as StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $time = $request->input('time') == "Semua" ? "" : $request->input('time');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Kegiatan::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'ilike', '%' . $search . '%');
        })
            ->when($time, function ($query) use ($time) {
                $query->where('waktu_kegiatan', 'ilike', '%' . $time);
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

        $fileData = base64_decode($request->photo, true);
        $fileName = Str::uuid() . '.' . $request->photo_ext;

        if ($fileData != false) {
            $disk = Storage::build([
                'driver' => 'local',
                'root' => storage_path('app/kegiatan'),
            ]);

            $post_data = array_merge($request->all(), [
                "created_by" => $user->id,
                'photo' => $fileName
            ]);

            $disk->put($fileName, $fileData);
            Kegiatan::updateOrCreate(['id' => $request->id], $post_data);
        }

        return response()->json(["success" => true, "message" => "Berhasil menyimpan data !"]);
    }

    public function destroy($id)
    {
        Kegiatan::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }

    public function image($file)
    {
        $storagePath = storage_path('app/kegiatan/' . $file);

        if (!Storage::exists('kegiatan/' . $file)) {
            abort(404);
        }

        return response()->file($storagePath);
    }
}
