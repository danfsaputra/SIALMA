<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlihmediaStoreRequest as StoreRequest;
use App\Models\Alihmedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AlihmediaController extends Controller
{
    public function getData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'asc' : 'desc';
        $user = $request->user();

        $data = Alihmedia::where('status', 'Belum Dikirim')
            //->when($user->role !== 'Admin', function ($query) use ($user) {
              //  $query->where('user_id', $user->id);
            //})
            ->when($search, function ($query) use ($search) {
                $query->where('opd', 'like', '%' . $search . '%')
                    ->orWhere('no_arsip', 'like', '%' . $search . '%')
                    ->orWhere('klasifikasi_arsip', 'like', '%' . $search . '%');
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
        $user = $request->user();

        // Inisialisasi variabel untuk file baru
        $fileName = null;

        // Ambil data model jika ada (untuk update)
        $alihmedia = Alihmedia::find($request->id);

        // Mengambil dan membersihkan format tanggal
        $tgl_arsip = $request->tgl_arsip;

        // Pastikan tanggal dalam format yang benar menggunakan Carbon
        $tgl_arsip = Carbon::parse($tgl_arsip)->addDay();
        
        // Jika ada file baru, proses file baru
        if ($request->file_arsip) {
            // Validasi file ekstensi
            $fileExtension = $request->photo_ext;
            $validExtensions = ['pdf'];
            if (!in_array($fileExtension, $validExtensions)) {
                return response()->json([
                    "success" => false,
                    "message" => "Ekstensi file tidak valid.",
                ], 400);
            }

            // Decode file base64
            $fileData = base64_decode($request->file_arsip, true);
            $fileName = Str::uuid() . '.' . $fileExtension;

            if ($fileData !== false) {
                // Pastikan file valid sebelum menyimpannya
                $disk = Storage::build([
                    'driver' => 'local',
                    'root' => storage_path('app/alma'),
                ]);

                $disk->put($fileName, $fileData);

                // Hapus file lama jika ada
                if ($alihmedia && $alihmedia->file_arsip) {
                    $disk->delete($alihmedia->file_arsip);
                }
            }
        } else {
            // Jika tidak ada file baru, gunakan file lama
            $fileName = $alihmedia->file_arsip ?? null;
        }

        // Siapkan data untuk disimpan
        $post_data = array_merge($request->except('file_arsip'), [
            "user_id" => $user->id,
            'file_arsip' => $fileName,
            'tgl_arsip' => $tgl_arsip,  // Pastikan tgl_arsip juga disertakan
        ]);

        // Simpan data
        $alihmedia = Alihmedia::updateOrCreate(["id" => $request->id], $post_data);

        return response()->json([
            "success" => true,
            "message" => "Berhasil menyimpan data!",
            "id" => $alihmedia->id,
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


    public function destroy($id)
    {
        try {
            $alihmedia = Alihmedia::findOrFail($id);
            $alihmedia->delete();

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
            $alihmedia = Alihmedia::findOrFail($id);
            return response()->json($alihmedia);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Data tidak ditemukan!",
            ], 404);
        }
    }
    
    public function getImage($file)
    {
        $storagePath = storage_path('app/alma/' . $file);

        if (is_file($storagePath)) {
            return response()->file($storagePath);
        } else {
            die("Tidak Dapat Menampilkan Data");
        }
    }
}