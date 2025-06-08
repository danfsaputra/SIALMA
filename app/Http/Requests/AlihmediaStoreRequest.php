<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlihmediaStoreRequest extends FormRequest
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
        //$file_rules = $this->id ? 'nullable' : 'required';

        return [
            'opd'               => 'required',
            'tgl_arsip'         => 'required',
            'no_arsip'          => 'required',
            'jenis_arsip'       => 'required',
            'klasifikasi_arsip' => 'required',
            'uraian'            => 'required',
            'no_box'            => 'required',
            'no_berkas'         => 'required',
            'keterangan'        => 'required',
            'status'            => 'required',
            'file_arsip'        => 'required',
            //'file_arsip'        => $file_rules,
        ];
    }

    public function messages(): array
    {
        return [
            'opd.required'                  => 'OPD harus dipilih',
            'tgl_arsip.required'            => 'Tanggal arsip harus diisi',
            'no_arsip.required'             => 'Nomor arsip harus diisi',
            'jenis_arsip.required'          => 'Jenis arsip harus diisi',
            'klasifikasi_arsip.required'    => 'Klasifikasi harus dipilih',
            'uraian.required'               => 'Uraian harus diisi',
            'no_box.required'               => 'Nomor Box harus diisi',
            'no_berkas.required'            => 'Nomor berkas harus diisi',
            'keterangan.required'           => 'Keterangan harus diisi',
            'status.required'               => 'Status harus diisi',
            'file_arsip.required'           => 'File arsip harus diisi',
        ];
    }
}
