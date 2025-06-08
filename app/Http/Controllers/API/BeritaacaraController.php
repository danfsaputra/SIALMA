<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaacaraStoreRequest as StoreRequest;
use App\Models\Beritaacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaacaraController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';

        $data = Beritaacara::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nomor_surat', 'like', '%' . $search . '%')
                    ->orWhere('tanggal', 'like', '%' . $search . '%')
                    ->orWhere('jenis_media', 'like', '%' . $search . '%');
            })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    public function store(StoreRequest $request)
{
    try {
        $beritaacara = Beritaacara::find($request->id);
        $tanggal = $beritaacara ? $request->tanggal : Carbon::parse($request->tanggal)->addDay();

        $fileName = $beritaacara->file_berita ?? null;
        $fileExtension = $request->photo_ext;

        if ($request->file_berita && !Str::contains($request->file_berita, 'undefined') && strlen($request->file_berita) > 100) {
            $validExtensions = ['pdf'];
            if (!in_array($fileExtension, $validExtensions)) {
                return response()->json([
                    "success" => false,
                    "message" => "Ekstensi file tidak valid.",
                ], 400);
            }

            $fileData = base64_decode($request->file_berita, true);
            $fileName = Str::uuid() . '.' . $fileExtension;

            if ($fileData !== false) {
                $disk = Storage::build([
                    'driver' => 'local',
                    'root' => storage_path('app/berita'),
                ]);

                $disk->put($fileName, $fileData);

                if ($beritaacara && $beritaacara->file_berita) {
                    $disk->delete($beritaacara->file_berita);
                }
            }
        }

        $post_data = array_merge($request->except('file_berita'), [
            'file_berita' => $fileName,
            'tanggal' => $tanggal,
        ]);

        $beritaacara = Beritaacara::updateOrCreate(["id" => $request->id], $post_data);

        return response()->json([
            "success" => true,
            "message" => "Berhasil menyimpan data!",
            "id" => $beritaacara->id,
        ]);
    } catch (\Exception $e) {
        Log::error('Error pada penyimpanan data Berita Acara: ' . $e->getMessage());
        return response()->json([
            "success" => false,
            "message" => "Terjadi kesalahan saat menyimpan data!",
        ], 500);
    }
}

    public function destroy($id)
    {
        try {
            $beritaacara = Beritaacara::findOrFail($id);
            $beritaacara->delete();

            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan saat menghapus data!",
            ], 500);
        }
    }

    public function getById($id)
    {
        try {
            $beritaacara = Beritaacara::findOrFail($id);
            return response()->json($beritaacara);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Data tidak ditemukan!",
            ], 404);
        }
    }

    public function getImage($file)
    {
        $storagePath = storage_path('app/berita/' . $file);

        if (is_file($storagePath)) {
            return response()->file($storagePath);
        } else {
            die("Tidak Dapat Menampilkan Data");
        }
    }
}