<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanStoreRequest extends FormRequest
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
            'tanggal_kegiatan'  => 'required',
            'waktu_kegiatan'    => 'required',
            'jenis_kegiatan'    => 'required',
            'keterangan'        => 'required',
            'photo'             => 'required'
        ];
    }

    /**
     * Get the message rules that apply to the request.
     *
     */
    public function messages(): array
    {
        return [
            'tanggal_kegiatan.required' => 'Tanggal kegiatan tidak boleh kosong',
            'waktu_kegiatan.required'   => 'Waktu kegiatan tidak boleh kosong',
            'jenis_kegiatan.required'   => 'Jenis kegiatan tidak boleh kosong',
            'keterangan.required'       => 'Keterangan tidak boleh kosong',
            'photo.required'            => 'Foto kegiatan harus diupload'
        ];
    }
}
