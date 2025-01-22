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
        $user = $request->user();

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
            $user = $request->user();

            // Inisialisasi variabel untuk file baru
            $fileName = null;

            // Ambil data model jika ada (untuk update)
            $beritaacara = Beritaacara::find($request->id);

            // Mengambil dan membersihkan format tanggal
            $tanggal = $request->tanggal;

            // Menghapus bagian setelah 'GMT' dan karakter yang tidak perlu
            $cleanedDate = preg_replace('/(GMT[^\d]*\d{4})[^)]*/', '$1', $tanggal);
            // Menghapus karakter penutup ')' yang tidak diperlukan
            $cleanedDate = rtrim($cleanedDate, ')');

            // Mengonversi tanggal yang sudah dibersihkan menjadi format yang diterima MySQL
            $tanggal = Carbon::parse($cleanedDate)->toDateTimeString();

            // Jika ada file baru, proses file baru
            if ($request->file_berita) {
                // Validasi file ekstensi
                $fileExtension = $request->photo_ext;
                $validExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];
                if (!in_array($fileExtension, $validExtensions)) {
                    return response()->json([
                        "success" => false,
                        "message" => "Ekstensi file tidak valid.",
                    ], 400);
                }

                // Decode file base64
                $fileData = base64_decode($request->file_berita, true);
                $fileName = Str::uuid() . '.' . $fileExtension;

                if ($fileData !== false) {
                    // Pastikan file valid sebelum menyimpannya
                    $disk = Storage::build([
                        'driver' => 'local',
                        'root' => storage_path('app/berita'),
                    ]);

                    $disk->put($fileName, $fileData);

                    // Hapus file lama jika ada
                    if ($beritaacara && $beritaacara->file_berita) {
                        $disk->delete($beritaacara->file_berita);
                    }
                }
            } else {
                // Jika tidak ada file baru, gunakan file lama
                $fileName = $beritaacara->file_berita ?? null;
            }

            // Siapkan data untuk disimpan
            $post_data = array_merge($request->except('file_berita', 'photo_ext'), [
                "user_id" => $user->id,
                'file_berita' => $fileName,
                'tanggal' => $tanggal,  // Pastikan tgl_arsip juga disertakan
            ]);

            // Simpan data
            $beritaacara = Beritaacara::updateOrCreate(["id" => $request->id], $post_data);

            return response()->json([
                "success" => true,
                "message" => "Berhasil menyimpan data!",
                "id" => $beritaacara->id,
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
        $file = basename($file); // Hindari path traversal
        $filePath = 'berita/' . $file;

        if (Storage::exists($filePath)) {
            return response()->file(storage_path('app/' . $filePath), [
                'Content-Disposition' => 'inline; filename="' . $file . '"',
                'Content-Type' => mime_content_type(storage_path('app/berita/' . $filePath)),
            ]);
        } else {
            abort(404, 'File tidak ditemukan');
        }
    }
}