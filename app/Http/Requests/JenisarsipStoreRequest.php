<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisarsipStoreRequest extends FormRequest
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
            'nm_arsip'        => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nm_arsip.required'       => 'Jenis Arsip harus diisi',
        ];
    }
}
