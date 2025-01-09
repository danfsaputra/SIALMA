<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaikabStoreRequest extends FormRequest
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
            'nip'               => 'required',
            'nama_lengkap'      => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required',
            'jenis_kelamin'     => 'required',
            'alamat'            => 'required',
            'nohp'              => 'required',
            'status_pegawai'    => 'required',
        ];
    }

    /**
     * Get the message rules that apply to the request.
     *
     */
    public function messages(): array
    {
        return [
            'nip.required'              => 'NIP / ID Pegawai tidak boleh kosong',
            'nama_lengkap.required'     => 'Nama lengkap tidak boleh kosong',
            'tempat_lahir.required'     => 'Tempat lahir tidak boleh kosong',
            'tanggal_lahir.required'    => 'Tanggal lahir tidak boleh kosong',
            'jenis_kelamin.required'    => 'Jenis kelamin harus dipilih',
            'alamat.required'           => 'Alamat tidak boleh kosong',
            'nohp.required'             => 'No. telepon tidak boleh kosong',
            'status_pegawai.required'   => 'Status pegawai harus dipilih',
        ];
    }
}
