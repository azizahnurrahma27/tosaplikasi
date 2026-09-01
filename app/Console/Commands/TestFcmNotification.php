<?php

namespace App\Console\Commands;

use App\Services\FcmService;
use Illuminate\Console\Command;

class TestFcmNotification extends Command
{
    protected $signature = 'fcm:test {idkelas} {--judul=Tugas Tes} {--mapel=Matematika}';

    protected $description = 'Kirim notifikasi FCM tes ke seluruh siswa pada satu kelas (untuk debugging kredensial/koneksi).';

    public function handle(FcmService $fcmService): int
    {
        $idkelas = (int) $this->argument('idkelas');

        $fcmService->sendTaskNotification(
            [
                'tugasFor' => 'kelas',
                'idkelas'  => $idkelas,
            ],
            [
                'type'    => 'task',
                'task_id' => 0,
                'judul'   => $this->option('judul'),
                'mapel'   => $this->option('mapel'),
            ]
        );

        $this->info('Selesai. Cek log Laravel (storage/logs/laravel.log) untuk hasil pengiriman per token.');

        return self::SUCCESS;
    }
}