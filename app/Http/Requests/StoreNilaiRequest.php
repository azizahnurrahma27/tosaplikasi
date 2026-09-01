<?php

namespace App\Http\Requests;

use App\Models\TjenisNilai;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class StoreNilaiRequest extends FormRequest
{
    protected ?Collection $tipeJenisNilaiMap = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nilai'                  => ['required', 'array', 'min:1'],
            'nilai.*'                => ['array'],
            'nilai.*.*.idjenisnilai' => ['required', 'integer', 'exists:mai1.tjenisnilai,id'],
            'nilai.*.*.nilai'        => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai.*.*.idtugas'      => ['nullable', 'integer', 'exists:mai1.ttugas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nilai.*.*.idjenisnilai.required' => 'Jenis nilai wajib dipilih.',
            'nilai.*.*.nilai.required'        => 'Nilai wajib diisi.',
            'nilai.*.*.nilai.numeric'         => 'Nilai harus berupa angka.',
            'nilai.*.*.idtugas.exists'        => 'Tugas yang dipilih tidak valid.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $tipeMap = $this->tipeJenisNilaiMap();

            foreach ((array) $this->input('nilai', []) as $idSiswa => $entries) {
                foreach ((array) $entries as $i => $entry) {
                    $idJenisNilai = $entry['idjenisnilai'] ?? null;
                    $tipe         = (int) ($tipeMap->get($idJenisNilai) ?? 0);

                    if ($tipe === 1 && empty($entry['idtugas'])) {
                        $validator->errors()->add(
                            "nilai.$idSiswa.$i.idtugas",
                            'Silakan pilih tugas terlebih dahulu untuk jenis nilai ini.'
                        );
                    }
                }
            }
        });
    }

    protected function tipeJenisNilaiMap(): Collection
    {
        if ($this->tipeJenisNilaiMap !== null) {
            return $this->tipeJenisNilaiMap;
        }

        $idsJenisNilai = collect($this->input('nilai', []))
            ->flatten(1)
            ->pluck('idjenisnilai')
            ->filter()
            ->unique()
            ->values();

        return $this->tipeJenisNilaiMap = TjenisNilai::query()
            ->whereIn('id', $idsJenisNilai)
            ->pluck('tipe', 'id');
    }
}