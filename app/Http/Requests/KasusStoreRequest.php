<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KasusStoreRequest extends FormRequest
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
            'nama_pelanggar'    => 'required',
            'nik_pelanggar'     => 'required',
            'waktu_kejadian'    => 'required',
            'sumber_informasi'  => 'required',
            'nomor_surat_link'  => 'required',
            'potensi_pad'       => 'required',
            'koordinat'         => 'required',
            'opd_pengampu'      => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pelanggar.required'    => 'Nama Pelanggar tidak boleh kosong',
            'nik_pelanggar.required'     => 'NIK Pelanggar tidak boleh kosong',
            'waktu_kejadian.required'    => 'Waktu Kejadian harus diisi',
            'sumber_informasi.required'  => 'Sumber Informasi tidak boleh kosong',
            'nomor_surat_link.required'  => 'Nomor Surat harus diisi',
            'potensi_pad.required'       => 'Potensi PAD harus diisi',
            'koordinat.required'         => 'koordinat harus diisi',
            'opd_pengampu.required'      => 'OPD Pengampu harus dipilih',
        ];
    }
}
