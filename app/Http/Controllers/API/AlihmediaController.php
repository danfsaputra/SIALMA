<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlihmediaStoreRequest as StoreRequest;
use App\Models\Alihmedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function store(StoreRequest $request)

    {
        $user = $request->user();

        // Inisialisasi variabel untuk file baru
        $fileName = null;

        // Ambil data model jika ada (untuk update)
        $alihmedia = Alihmedia::find($request->id);

        // Jika ada file baru, proses file baru
        if ($request->file_arsip) {
            $fileData = base64_decode($request->file_arsip, true);
            $fileName = Str::uuid() . '.' . $request->photo_ext;

            if ($fileData !== false) {
                $disk = Storage::build([
                    'driver' => 'local',
                    'root' => storage_path('app/alihmedia'),
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
        $post_data = array_merge($request->except('file_arsip', 'photo_ext'), [
            "user_id" => $user->id,
            'file_arsip' => $fileName,
        ]);

        // Simpan data
        $alihmedia = Alihmedia::updateOrCreate(["id" => $request->id], $post_data);

        return response()->json([
            "success" => true,
            "message" => "Berhasil menyimpan data!",
            "id" => $alihmedia->id,
        ]);
    }



    // public function store(StoreRequest $request)
    // {
    //     $user = $request->user();

    //     $fileData = base64_decode($request->file_arsip, true);
    //     $fileName = Str::uuid() . '.' . $request->photo_ext;

    //     if ($fileData !== false) {
    //         $disk = Storage::build([
    //             'driver' => 'local',
    //             'root' => storage_path('app/alihmedia'),
    //         ]);

    //     $post_data = array_merge($request->all(), [
    //         "user_id" => $user->id,
    //         'file_arsip' => $fileName
    //         ]);

    //     $disk->put($fileName, $fileData);

    //     $alihmedia = Alihmedia::updateOrCreate(["id" => $request->id], $post_data);

    //     }

    //     return response()->json(["success" => true, "message" => "Berhasil menyimpan data !", "id" => $alihmedia->id]);
    // }

    public function destroy($id)
    {
        Alihmedia::whereId($id)->delete();

        return response()->json(["success" => true, "message" => "Berhasil menghapus data !"]);
    }

    public function getById($id)
    {
        $alihmedia = Alihmedia::whereId($id)->first();

        return response()->json($alihmedia);
    }

    public function image($file)
    {
        $storagePath = storage_path('app/alihmedia/' . $file);

        if (!Storage::exists('alihmedia/' . $file)) {
            abort(404);
        }

        return response()->file($storagePath);
    }

    // public function getPdf($file)
    // {
    //     $storagePath = storage_path('app/alihmedia/' . $file);

    //     if (!Storage::exists('alihmedia/' . $file)) {
    //         abort(404);
    //     }

    //     return response()->file($storagePath);
    // }

    // public function getPDF($id)
    // {
    //     $data = Alihmedia::findOrFail($id);

    //     $pdf = Pdf::loadView('pdf_template', compact('data'));

    //     // return $pdf->download('preview.pdf');
    //     return $pdf->stream();
    // }

    public function getImage($file)
    {
        $file = basename($file); // Hindari path traversal
        $filePath = 'alihmedia/' . $file;

        if (Storage::exists($filePath)) {
            return response()->file(storage_path('app/' . $filePath), [
                'Content-Disposition' => 'inline; filename="' . $file . '"',
                'Content-Type' => mime_content_type(storage_path('app/alihmedia/' . $filePath)),
            ]);
        } else {
            abort(404, 'File tidak ditemukan');
        }
    }

    // public function getImage($file)
    // {
    //     $storagePath = storage_path('app/alihmedia/' . $file);

    //     if (is_file($storagePath)) {
    //         return response()->file($storagePath);
    //     } else {
    //         die("Tidak Dapat Menampilkan Data");
    //     }
    // }
}
