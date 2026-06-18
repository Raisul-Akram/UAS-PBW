<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeknisiRequest extends FormRequest
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
            'nama' => 'required|min:3',
            'no_hp' => 'required|regex:/^08[0-9]{8,11}$/',
            'spesialisasi' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama teknisi wajib diisi.',
            'nama.min' => 'Nama teknisi minimal harus 3 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid (harus diawali 08 dan berjumlah 10-13 digit).',
            'spesialisasi.required' => 'Spesialisasi wajib diisi.',
        ];
    }
}
