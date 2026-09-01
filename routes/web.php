<?php

use App\Http\Controllers\AbsensiSiswaController;
use App\Http\Controllers\CatatanKasusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JurnalKonselingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/guru/login');
});

// ── Public: Login Guru ──────────────────────────────────────────────────────
Route::prefix('guru')->name('guru.')->group(function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login'])
        ->name('login.submit');

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout')
        ->middleware('auth.guru');

});

// ── Protected: Hanya Guru yang Sudah Login ──────────────────────────────────
Route::prefix('guru')->name('guru.')->middleware('auth.guru')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'jenjang'])
         ->name('dashboard');

    Route::get('sekolah/{tin}', [DashboardController::class, 'sekolah'])
        ->name('sekolah')
        ->where('tin', '[0-9]+');

    Route::get('kelas/{id}', [DashboardController::class, 'kelas'])
        ->name('detailkelas')
        ->where('id', '[0-9]+');

    Route::get('/tugas/{id}', [TaskController::class, 'create'])->name('tugas');

    Route::post('tugassimpan/{id}', [TaskController::class, 'store'])
        ->name('admin.tasks.store');

    Route::get('/absensisiswa/{id}', [AbsensiSiswaController::class, 'index'])
        ->name('absensisiswa');

    Route::get('/siswa/{id}', [SiswaController::class, 'siswa'])
        ->name('siswa')
        ->where('id', '[0-9]+');

    Route::get('/datasiswa/{id}', [SiswaController::class, 'datasiswa'])
        ->name('datasiswa')
        ->where('id', '[0-9]+');

    // ── Izin Siswa (per kelas) ──
    Route::prefix('izin/kelas/{id}')->where(['id' => '[0-9]+'])->group(function () {
        Route::get('/', [IzinController::class, 'byKelas'])
            ->name('izin.by_kelas');

        Route::get('/pending', [IzinController::class, 'pendingByKelas'])
            ->name('izin.pending');

        Route::post('/{izin}/approve', [IzinController::class, 'approve'])
            ->name('izin.approve')
            ->where('izin', '[0-9]+');

        Route::post('/{izin}/reject', [IzinController::class, 'reject'])
            ->name('izin.reject')
            ->where('izin', '[0-9]+');
    });

    Route::prefix('kelas/{idkelas}/jurnal-konseling')->group(function () {
        Route::get('/',                [JurnalKonselingController::class, 'index'])->name('jurnalkonseling');
        Route::get('/download',        [JurnalKonselingController::class, 'download'])->name('jurnalkonseling.download');
        Route::get('/laporan',         [JurnalKonselingController::class, 'laporan'])->name('jurnalkonseling.laporan');

        Route::get('/siswa/{idsis}/download', [JurnalKonselingController::class, 'downloadSiswa'])->name('jurnalkonseling.siswa.download');
        Route::get('/siswa/{idsis}/laporan',  [JurnalKonselingController::class, 'laporanSiswa'])->name('jurnalkonseling.siswa.laporan');

        Route::get('/siswa/{idsis}',           [JurnalKonselingController::class, 'show'])->name('jurnalkonseling.show');
        Route::get('/siswa/{idsis}/create',    [JurnalKonselingController::class, 'create'])->name('jurnalkonseling.create');
        Route::post('/siswa/{idsis}',          [JurnalKonselingController::class, 'store'])->name('jurnalkonseling.store');

        Route::get('/{id}/edit',    [JurnalKonselingController::class, 'edit'])->name('jurnalkonseling.edit');
        Route::put('/{id}',         [JurnalKonselingController::class, 'update'])->name('jurnalkonseling.update');
        Route::delete('/{id}',      [JurnalKonselingController::class, 'destroy'])->name('jurnalkonseling.destroy');

        Route::get('/download-pdf', [JurnalKonselingController::class, 'downloadPdf'])
    ->name('jurnalkonseling.download-pdf');
 
Route::get('/{idsis}/download-pdf', [JurnalKonselingController::class, 'downloadSiswaPdf'])
    ->name('jurnalkonseling.download-siswa-pdf');

 
    });

    // ── Informasi Kelas (CRUD) ──
    Route::prefix('kelas/{idkelas}/info')->name('informasi.')->group(function () {
        Route::get('/',            [InformasiController::class, 'index'])->name('index');
        Route::get('/create',      [InformasiController::class, 'create'])->name('create');
        Route::post('/',           [InformasiController::class, 'store'])->name('store');
        Route::get('/{id}/edit',   [InformasiController::class, 'edit'])->name('edit');
        Route::put('/{id}',        [InformasiController::class, 'update'])->name('update');
        Route::delete('/{id}',     [InformasiController::class, 'destroy'])->name('destroy');
    });
Route::prefix('kelas/{idkelas}/catatan-kasus')->group(function () {
    Route::get('/',    [CatatanKasusController::class, 'index'])->name('catatankasus');
    Route::get('/pdf', [CatatanKasusController::class, 'pdfKelas'])->name('catatankasus.pdfkelas'); // <-- baru

    Route::get('/siswa/{idsis}',        [CatatanKasusController::class, 'show'])->name('catatankasus.show');
    Route::get('/siswa/{idsis}/create', [CatatanKasusController::class, 'create'])->name('catatankasus.create');
    Route::get('/siswa/{idsis}/pdf',    [CatatanKasusController::class, 'pdf'])->name('catatankasus.pdf');
    Route::post('/siswa/{idsis}',       [CatatanKasusController::class, 'store'])->name('catatankasus.store');

    Route::get('/{id}/edit', [CatatanKasusController::class, 'edit'])->name('catatankasus.edit');
    Route::put('/{id}',      [CatatanKasusController::class, 'update'])->name('catatankasus.update');
    Route::delete('/{id}',   [CatatanKasusController::class, 'destroy'])->name('catatankasus.destroy');
});

Route::prefix('penilaian')->group(function () {
    Route::get('{idKelas}', [PenilaianController::class, 'index'])
        ->whereNumber('idKelas')
        ->name('penilaiansiswa');
 
    Route::get('{idKelas}/{idPelajaran}', [PenilaianController::class, 'show'])
        ->whereNumber(['idKelas', 'idPelajaran'])
        ->name('penilaiansiswa.show');
 
    Route::post('{idKelas}/{idPelajaran}', [PenilaianController::class, 'store'])
        ->whereNumber(['idKelas', 'idPelajaran'])
        ->name('penilaiansiswa.store');
 
    Route::get('{idKelas}/{idPelajaran}/laporan', [PenilaianController::class, 'laporan'])
        ->whereNumber(['idKelas', 'idPelajaran'])
        ->name('penilaiansiswa.laporan');
    Route::get('{idKelas}/{idPelajaran}/tugas-by-context', [PenilaianController::class, 'tugasByContext'])
    ->name('penilaiansiswa.tugas-by-context');
});

Route::prefix('rapor')->group(function () {
    Route::get('/',           [RaporController::class, 'index'])->name('raporsiswa');
    Route::get('/siswa/{idsiswa}', [RaporController::class, 'showSiswa'])->name('raporsiswa.show')->whereNumber('idsiswa'); // <-- BARU
    Route::get('/create',     [RaporController::class, 'create'])->name('raporsiswa.create');
    Route::post('/',          [RaporController::class, 'store'])->name('raporsiswa.store');
    Route::get('/{id}/edit',  [RaporController::class, 'edit'])->name('raporsiswa.edit')->whereNumber('id');
    Route::put('/{id}',       [RaporController::class, 'update'])->name('raporsiswa.update')->whereNumber('id');
    Route::delete('/{id}',    [RaporController::class, 'destroy'])->name('raporsiswa.destroy')->whereNumber('id');
});
});