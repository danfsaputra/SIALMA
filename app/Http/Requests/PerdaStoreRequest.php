<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerdaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal_kegiatan'          => 'required',
            'perda'                     => 'required',
            'jenis_pelanggaran'         => 'required',
            'urusan'                    => 'required',
            'jenis_tertib'              => 'required',
            'tindak_lanjut'             => 'required',
            'sanksi'                    => 'required',
            'status_proses'             => 'required',
            'tanggal_sidang_tipiring'   => 'required',
            'keterangan'                => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_kegiatan.required'         => 'Tanggal Kegiatan harus diisi',
            'perda.required'                    => 'Perda harus dipilih',
            'jenis_pelanggaran.required'        => 'Jenis Pelanggaran harus dipilih',
            'urusan.required'                   => 'Urusan harus dipilih',
            'jenis_tertib.required'             => 'Jenis Tertib harus dipilih',
            'tindak_lanjut.required'            => 'Tindak Lanjut harus dipilih',
            'sanksi.required'                   => 'Sanksi harus dipilih',
            'status_proses.required'            => 'Status Proses harus dipilih',
            'tanggal_sidang_tipiring.required'  => 'Tanggal Sidang harus diisi',
            'keterangan.required'               => 'Keterangan harus diisi',
        ];
    }
}
