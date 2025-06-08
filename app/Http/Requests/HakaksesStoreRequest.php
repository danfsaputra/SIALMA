<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HakaksesStoreRequest extends FormRequest
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
            'hak_akses'        => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'hak_akses.required'       => 'Hak Akses harus diisi',
        ];
    }
}
