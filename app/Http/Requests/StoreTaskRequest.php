<?php

namespace App\Http\Requests;

use App\Services\TaskService;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    private int $resolvedIdGuru;
    private int $resolvedIdPelajaran;
    private string $resolvedMapel;

    public function authorize(): bool
    {
        return $this->user('guru') !== null;
    }


    public function rules(): array
    {
        return [
            'idkelas'         => ['required', 'integer'],
            'idpelajaran'     => ['required', 'integer'],
            'tglpenugasan'    => ['required', 'date'],
            'tglpengumpulan'  => ['required', 'date', 'after_or_equal:tglpenugasan'],
            'tugasFor'        => ['required', 'in:kelas,siswa'],
            'siswa_ids'       => ['required_if:tugasFor,siswa', 'array'],
            'siswa_ids.*'     => ['integer'],
            'judul'           => ['required', 'string', 'max:255'],
            'deskripsi'       => ['required', 'string'],
            'lampiran'        => ['nullable', 'file', 'max:10240'],
        ];
    }

    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function (ValidatorContract $validator) {
            $taskService = app(TaskService::class);

            $guru = $this->user('guru'); // <-- pakai guard 'guru' eksplisit

            if ($guru === null) {
                $validator->errors()->add('idguru', 'Sesi guru tidak valid, silakan login ulang.');
                return;
            }

            $idguru      = $guru->idguru;
            $idkelas     = (int) $this->input('idkelas');
            $idpelajaran = (int) $this->input('idpelajaran');

            $mapel = $taskService->resolveMapelForGuru($idguru, $idkelas, $idpelajaran);

            if ($mapel === null) {
                $validator->errors()->add('idpelajaran', 'Mata pelajaran tidak sesuai penugasan Anda di kelas ini.');
                return;
            }

            $this->resolvedIdGuru      = (int) $idguru;
            $this->resolvedIdPelajaran = $idpelajaran;
            $this->resolvedMapel       = $mapel;
        });
    }

    public function resolvedIdGuru(): int { return $this->resolvedIdGuru; }
    public function resolvedIdPelajaran(): int { return $this->resolvedIdPelajaran; }
    public function resolvedMapel(): string { return $this->resolvedMapel; }
}