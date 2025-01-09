<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SarprasStoreRequest extends FormRequest
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
            'nama'      => 'required',
            'jumlah'    => 'required',
        ];
    }

    /**
     * Get the message rules that apply to the request.
     *
     */
    public function messages(): array
    {
        return [
            'nama.required'     => 'Deskripsi sarana prasarana tidak boleh kosong',
            'jumlah.required'   => 'Jumlah tidak boleh kosong',
        ];
    }
}
