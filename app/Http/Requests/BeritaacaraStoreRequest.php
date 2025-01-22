<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaacaraStoreRequest extends FormRequest
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
            'nomor_surat' => 'required',
            'tanggal' => 'required',
            'tempat' => 'required',
            'jenis_media' => 'required',
            'jumlah_arsip' => 'required',
            'keterangan_arsip' => 'required',
            'proses' => 'required',
            'pelaksana' => 'required',
            'kepala_dinas' => 'required',
            'file_berita' => 'required',

        ];
    }

    public function messages(): array
    {
        return [
            'nomor_surat.required' => 'Nomor surat harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'tempat.required' => 'Tempat harus diisi',
            'jenis_media.required' => 'Jenis media harus diisi',
            'jumlah_arsip.required' => 'Jumlah arsip harus diisi',
            'keterangan_arsip.required' => 'Keterangan arsip harus diisi',
            'proses.required' => 'Proses harus diisi',
            'pelaksana.required' => 'Pelaksana harus diisi',
            'kepala_dinas.required' => 'Kepala dinas harus diisi',
            'file_berita.required' => 'File berita harus diisi',
        ];
    }
}
