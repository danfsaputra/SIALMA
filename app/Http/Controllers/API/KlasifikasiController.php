<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Klasifikasi;
use Illuminate\Http\Request;
//use App\Http\Controllers\API\ValidasidataController;


class KlasifikasiController extends Controller
{
    public function getData(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';
        $user = $request->user();

        $data = Klasifikasi::where('nm_klasifikasi', 'like', '%' . $search . '%')
            ->when($search, function ($query) use ($search) {
            $query->where('nm_klasifikasi', 'like', '%' . $search . '%')
            ->orWhere('hak_akses', 'like', '%' . $search . '%')
            ->orWhere('penyusutan_akhir', 'like', '%' . $search . '%');
        })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }

    /*public function getAlihmediaData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $sortField = $request->input('sortField');
        $sortOrder = $request->input('sortOrder') == 1 ? 'desc' : 'asc';

        $data = Klasifikasi::with(['alihmedia' => function ($query) {
                $query->where('status', 'disetujui');
            }])
            ->whereHas('alihmedia', function ($query) {
                $query->whereColumn('klasifikasi_arsip', 'nm_klasifikasi');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('nm_klasifikasi', 'like', '%' . $search . '%')
                    ->orWhere('hak_akses', 'like', '%' . $search . '%')
                    ->orWhere('penyusutan_akhir', 'like', '%' . $search . '%');
            })
            ->when($sortField, function ($query) use ($sortField, $sortOrder) {
                $query->orderBy($sortField, $sortOrder);
            })
            ->paginate($perPage);

        return response()->json($data);
    }*/
    }
