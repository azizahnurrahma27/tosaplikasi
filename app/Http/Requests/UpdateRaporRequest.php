<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRaporRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'idsiswa'      => ['required', 'integer', Rule::exists('tsiswa', 'id')],
            'idkelas'      => ['required', 'integer', Rule::exists('tkelas', 'id')],
            'idta'         => ['required', 'integer', Rule::exists('tta', 'id')],
            'idjenisrapot' => ['required', 'integer', Rule::exists('tjenisrapot', 'id')->where('aktif', 1)],
            'tanggal'      => ['required', 'date'],
            'deskripsi'    => ['nullable', 'string', 'max:5000'],
            'lampiran'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'idsiswa.required'      => 'Siswa wajib dipilih.',
            'idjenisrapot.required' => 'Jenis rapor wajib dipilih.',
            'idjenisrapot.exists'   => 'Jenis rapor tidak valid atau tidak aktif.',
            'lampiran.mimes'        => 'Lampiran harus berupa PDF, JPG, JPEG, atau PNG.',
            'lampiran.max'          => 'Ukuran lampiran maksimal 5MB.',
        ];
    }

    public function validatedData(): array
    {
        return $this->safe()->except('lampiran');
    }
}