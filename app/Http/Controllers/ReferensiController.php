<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use App\Models\OPD;
use App\Models\Hakakses;
use App\Models\Keamanan;
use App\Models\Penyusutan;
use Illuminate\Http\Request;


class ReferensiController extends Controller
{
    public function getKlasifikasi()
    {
        $klasifikasi = Klasifikasi::all();

        return response()->json($klasifikasi);
    }

    public function getOPD()
    {
        #$user = $request->user();
        #$department = $request->department();

        #$department = OPD::WhereId($user->departments_id);
        $opd = OPD::all();

        #$opd = OPD::where($department->id, $user->departments_id);

        return response()->json($opd);


        #$user = $request->user();

        // Mengambil data OPD yang memiliki departments_id sama dengan departments_id milik user
        #$opd = OPD::where('id', $user->departments_id)->get();

        #return response()->json($opd);
    }

    public function getHakakses()
    {
        try {
            $hakakses = Hakakses::all();
            return response()->json($hakakses);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Gagal memuat data hak akses!",
            ], 500);
        }
    }

    public function getKeamanan()
    {
        try {
            $keamanan = Keamanan::all();
            return response()->json($keamanan);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Gagal memuat data hak akses!",
            ], 500);
        }
    }

    public function getPenyusutan()
    {
        try {
            $penyusutan = Penyusutan::all();
            return response()->json($penyusutan);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Gagal memuat data hak akses!",
            ], 500);
        }
    }

    // public function getDesa($id)
    // {
    //     $desa = Desa::where('id_kecamatan', $id)->get();

    //     return response()->json($desa);
    // }
}
