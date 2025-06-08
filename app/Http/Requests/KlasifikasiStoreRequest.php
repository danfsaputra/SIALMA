<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KlasifikasiStoreRequest extends FormRequest
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
            'nm_klasifikasi'        => 'required',
            'retensi_aktif'         => 'required',
            'retensi_inaktif'       => 'required',
            'penyusutan_akhir'      => 'required',
            'hak_akses'             => 'required',
            'klas_keamanan'         => 'required',
            'status'                => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nm_klasifikasi.required'       => 'Klasifikasi harus diisi',
            'retensi_aktif.required'        => 'retensi aktif harus diisi',
            'retensi_inaktif.required'      => 'retensi inaktif harus diisi',
            'penyusutan_akhir.required'     => 'penyusuatan harus diisi',
            'hak_akses.required'            => 'hak akses harus diisi',
            'klas_keamanan.required'        => 'klasifikasi keamanan diisi',
            'status.required'               => 'status harus diisi',
        ];
    }
}
