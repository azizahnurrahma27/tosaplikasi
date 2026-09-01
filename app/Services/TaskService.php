<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventTarget;
use App\Models\Tgurumengajar;
use App\Models\Tkelsis;
use App\Models\Tpelajaran;
use App\Models\Ttugas1;
use App\Models\Ttugas;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class TaskService
{
    private const KATEGORI_TUGAS = 3;

    private const TARGET_TYPE_KELAS = 3;
    private const TARGET_TYPE_SISWA = 4;

    private const TUGAS_FOR_KELAS = 'kelas';
    private const TUGAS_FOR_SISWA = 'siswa';

    public function __construct(private readonly FcmService $fcmService)
    {
    }

    public function store(array $data, ?UploadedFile $attachment, int $idguru, int $idpelajaran): Event
    {
        $tugas = null;

        /** @var Event $event */
        $event = DB::connection('mai1')->transaction(function () use ($data, $attachment, $idguru, $idpelajaran, &$tugas) {

            $attachmentMeta = $attachment ? $this->storeAttachment($attachment) : null;

            $meta = [
                'mapel' => $data['mapel'],
                'type'  => 'tugas',
            ];

            if ($attachmentMeta) {
                $meta['attachment'] = $attachmentMeta;
            }

            $event = Event::create([
                'judul'      => $data['judul'],
                'desk'       => strip_tags($data['deskripsi']),
                'start_at'   => $data['tglpenugasan'],
                'end_at'     => $data['tglpengumpulan'],
                'fullday'    => true,
                'lokasi'     => null,
                'penting'    => false,
                'sifat'      => 1,
                'kategori_id'=> self::KATEGORI_TUGAS,
                'sta'        => true,
                'meta'       => $meta,
            ]);

            $this->createTargets($event, $data);

            $tugas = $this->createTugas($data, $idguru, $idpelajaran, $attachmentMeta);

            $studentIds = $this->resolveStudentIdsForTarget($data);

            $this->createTugasDetails($tugas, $studentIds, $idguru);

            return $event;
        });

        if (! $tugas instanceof Ttugas) {

            throw new \RuntimeException('Gagal membuat tugas: transaksi tidak menghasilkan data yang diharapkan.');
        }

        try {
            $this->fcmService->sendTaskNotification($data, [
                'type'    => 'task',
                'task_id' => $tugas->id,
                'judul'   => $data['judul'],
                'mapel'   => $data['mapel'],
            ]);
        } catch (\Throwable $e) {
            report($e);
        }

        return $event;
    }

    public function getMataPelajaranForGuruDiKelas(int $idguru, int $idkelas): Collection
    {
        return Tgurumengajar::query()
            ->where('idguru', $idguru)
            ->where('idkelas', $idkelas)
            ->with('pelajaran:id,nam')
            ->get()
            ->map(fn ($row) => [
                'idpelajaran' => $row->idpelajaran,
                'nam'         => $row->pelajaran->nam ?? '-',
            ]);
    }

    public function resolveMapelForGuru(int $idguru, int $idkelas, int $idpelajaran): ?string
    {
        $valid = Tgurumengajar::query()
            ->where('idguru', $idguru)
            ->where('idkelas', $idkelas)
            ->where('idpelajaran', $idpelajaran)
            ->exists();

        if (! $valid) {
            return null;
        }

        return Tpelajaran::find($idpelajaran)?->nam;
    }


    private function createTugas(array $data, int $idguru, int $idpelajaran, ?array $attachmentMeta): Ttugas
    {
        return Ttugas::create([
            'id'             => (Ttugas::max('id') + 1),
            'idkelas'        => $data['idkelas'],
            'idguru'         => $idguru,
            'idpelajaran'    => $idpelajaran,
            'mapel'          => $data['mapel'],
            'tglpenugasan'   => $data['tglpenugasan'],
            'tglpengumpulan' => $data['tglpengumpulan'],
            'judul'          => $data['judul'],
            'deskripsi'      => strip_tags($data['deskripsi']),
            'lampiran'       => $attachmentMeta['path'] ?? null,
            'tugasFor'       => $data['tugasFor'],
            'createat'       => now(),
            'createby'       => $idguru,
        ]);
    }

  private function createTargets(Event $event, array $data): void
    {
        if ($data['tugasFor'] === self::TUGAS_FOR_KELAS) {

            EventTarget::create([
                'event_id'    => $event->id,
                'target_type' => self::TARGET_TYPE_KELAS,
                'target_id'   => $data['idkelas'],
            ]);

            return;
        }


        $rows = array_map(
            static fn ($studentId) => [
                'event_id'    => $event->id,
                'target_type' => self::TARGET_TYPE_SISWA,
                'target_id'   => $studentId,
            ],
            $data['siswa_ids']
        );

        EventTarget::insert($rows);
    }

    private function createTugasDetails(Ttugas $tugas, array $studentIds, int $idguru): void
    {
        if (empty($studentIds)) {
            return;
        }

        $rows = array_map(static fn ($studentId) => [
            'idtugas'  => $tugas->id,
            'idsiswa'  => $studentId,
            'status'   => 'belum',
            'nilai'    => null,
            'catatan'  => null,
            'createat' => now(),
            'createby' => $idguru,
        ], $studentIds);

        Ttugas1::insert($rows);
    }

    private function resolveStudentIdsForTarget(array $data): array
    {
        if ($data['tugasFor'] === self::TUGAS_FOR_SISWA) {
            return array_values(array_unique($data['siswa_ids']));
        }

        return Tkelsis::query()
            ->where('idkel', $data['idkelas'])
            ->pluck('ids')
            ->unique()
            ->values()
            ->all();
    }

    private function storeAttachment(UploadedFile $file): array
    {
        $path = $file->store('tugas-proyek', 'public');

        return [
            'path'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'size'          => $file->getSize(),
            'mime'          => $file->getClientMimeType(),
        ];
    }
    
    public function resolveStudentIdsForEvent(Event $event): array
    {
        $studentIds = [];

        foreach ($event->targets as $target) {
            if ($target->target_type === self::TARGET_TYPE_KELAS) {
                $studentIds = array_merge(
                    $studentIds,
                    Tkelsis::query()
                        ->where('idkel', $target->target_id)
                        ->pluck('ids')
                        ->all()
                );
            } elseif ($target->target_type === self::TARGET_TYPE_SISWA) {
                $studentIds[] = $target->target_id;
            }
        }

        return array_values(array_unique($studentIds));
    }
}