<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autentikasi ditangani oleh middleware rute
    }

    /**
     * Persiapkan data untuk validasi (bersihkan format titik ribuan).
     */
    protected function prepareForValidation()
    {
        if ($this->has('estimasi_biaya')) {
            $this->merge([
                'estimasi_biaya' => preg_replace('/[^0-9]/', '', $this->estimasi_biaya),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nama_perangkat' => 'required|min:3',
            'jenis_kerusakan' => 'required',
        ];

        if ($this->is('admin/*')) {
            $rules['estimasi_biaya'] = 'required|numeric|min:0';
            $rules['tgl_estimasi_selesai'] = 'required|date|after:today';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nama_perangkat.required' => 'Nama perangkat wajib diisi.',
            'nama_perangkat.min' => 'Nama perangkat minimal harus 3 karakter.',
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi.',
            'estimasi_biaya.required' => 'Estimasi biaya wajib diisi.',
            'estimasi_biaya.numeric' => 'Estimasi biaya harus berupa angka.',
            'estimasi_biaya.min' => 'Estimasi biaya minimal adalah 0.',
            'tgl_estimasi_selesai.required' => 'Tanggal estimasi selesai wajib diisi.',
            'tgl_estimasi_selesai.date' => 'Format tanggal estimasi selesai tidak valid.',
            'tgl_estimasi_selesai.after' => 'Tanggal estimasi selesai harus setelah hari ini.',
        ];
    }
}
