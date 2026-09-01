@extends('layouts.app')

@section('title', 'Jenjang ' . ($jenjang->nam ?? ''))

@section('styles')
<style>
    /* ══════════════ ROOT VARIABLES ══════════════ */
    :root {
        --pk-dark:    #16233c;
        --pk-blue:    #2c5f8a;
        --pk-light:   #4a8fc7;
        --pk-bg:      #f5f8fb;
        --pk-white:   #ffffff;
        --pk-border:  #e7ecf2;
        --pk-text:    #6b7a8f;
        --pk-text-2:  #94a3b8;
        --pk-shadow-sm: 0 1px 3px rgba(22, 35, 60, 0.06);
        --pk-shadow:    0 4px 16px rgba(22, 35, 60, 0.08);
        --pk-shadow-lg: 0 16px 40px rgba(22, 35, 60, 0.14);
        --pk-radius:    14px;
        --pk-radius-sm: 10px;
        --pk-ease: cubic-bezier(0.4, 0, 0.2, 1);
    }

    #page-content { font-family: 'Poppins', sans-serif; }

    /* ══════════════ PAGE HEADER ══════════════ */
    .pk-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--pk-border);
    }

    .pk-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    /* ── TOMBOL KEMBALI (FIX: pakai SVG, bukan icon font,
           supaya PASTI muncul walau font-icon telat load
           saat konten di-fetch via AJAX tab) ── */
    .pk-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--pk-white);
        border: 1px solid var(--pk-border);
        color: var(--pk-dark);
        transition: all 0.25s var(--pk-ease);
        text-decoration: none;
        flex-shrink: 0;
        overflow: hidden;
    }
    .pk-back-btn svg {
        width: 19px;
        height: 19px;
        stroke: currentColor;
        flex-shrink: 0;
        transition: transform 0.25s var(--pk-ease);
    }
    .pk-back-btn:hover {
        background: var(--pk-blue);
        color: #fff;
        border-color: var(--pk-blue);
        box-shadow: 0 6px 16px rgba(44, 95, 138, 0.28);
    }
    .pk-back-btn:hover svg { transform: translateX(-3px); }

    .pk-title-group { min-width: 0; }

    .pk-eyebrow {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: var(--pk-light);
        margin-bottom: 3px;
    }
    .pk-eyebrow svg { width: 13px; height: 13px; stroke: currentColor; flex-shrink: 0; }

    .pk-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--pk-dark);
        letter-spacing: -0.4px;
        line-height: 1.25;
        margin: 0;
    }

    .pk-subtitle {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--pk-text);
        font-weight: 400;
        margin-top: 4px;
    }
    .pk-subtitle svg { width: 14px; height: 14px; stroke: currentColor; flex-shrink: 0; opacity: 0.8; }

    .pk-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--pk-dark);
        color: #fff;
        padding: 9px 18px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
        white-space: nowrap;
        box-shadow: var(--pk-shadow-sm);
    }
    .pk-badge svg { width: 14px; height: 14px; stroke: #9ec4ea; flex-shrink: 0; }

    /* ══════════════ STATS ══════════════ */
    .pk-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 220px));
        gap: 14px;
        margin-bottom: 32px;
    }

    .pk-stat {
        background: var(--pk-white);
        padding: 18px 20px;
        border-radius: var(--pk-radius);
        box-shadow: var(--pk-shadow-sm);
        border: 1px solid var(--pk-border);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.25s var(--pk-ease);
    }
    .pk-stat:hover { box-shadow: var(--pk-shadow); transform: translateY(-2px); border-color: rgba(74,143,199,0.35); }

    .pk-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: linear-gradient(135deg, rgba(74,143,199,0.15), rgba(44,95,138,0.10));
        color: var(--pk-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .pk-stat-icon svg { width: 20px; height: 20px; stroke: currentColor; }

    .pk-stat-number {
        font-size: 22px;
        font-weight: 700;
        color: var(--pk-dark);
        line-height: 1.1;
        letter-spacing: -0.3px;
    }

    .pk-stat-label {
        font-size: 11px;
        color: var(--pk-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        margin-top: 3px;
    }

    /* ══════════════ SECTION LABEL ══════════════ */
    .pk-section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--pk-dark);
        margin-bottom: 16px;
    }
    .pk-section-label svg { width: 16px; height: 16px; stroke: currentColor; flex-shrink: 0; }
    .pk-section-label .line { height: 1px; flex: 1; background: var(--pk-border); }

    /* ══════════════ GRID KELAS ══════════════ */
    /* FIX: minmax(210px, 240px) bukan 1fr, biar kalau kelas cuma 1-2,
       kartunya nggak melar aneh memenuhi baris penuh. */
    .kelas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 240px));
        gap: 20px;
        margin-bottom: 36px;
    }

    .kelas-card {
        background: var(--pk-white);
        border-radius: var(--pk-radius);
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: all 0.3s var(--pk-ease);
        box-shadow: var(--pk-shadow-sm);
        border: 1px solid var(--pk-border);
        height: 100%;
    }
    .kelas-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--pk-shadow-lg);
        border-color: rgba(74,143,199,0.4);
    }

    .kelas-img {
        position: relative;
        height: 148px;
        overflow: hidden;
        background: var(--pk-bg);
    }
    .kelas-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s var(--pk-ease);
    }
    .kelas-card:hover .kelas-img img { transform: scale(1.08); }

    .kelas-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(22, 35, 60, 0.72) 0%, rgba(22, 35, 60, 0) 55%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 14px;
    }
    .kelas-card:hover .kelas-overlay { opacity: 1; }

    .kelas-overlay .view-icon {
        color: #fff;
        font-size: 12.5px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(8px);
        padding: 6px 16px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.28);
        transform: translateY(6px);
        transition: all 0.3s var(--pk-ease);
    }
    .view-icon svg { width: 13px; height: 13px; stroke: currentColor; }
    .kelas-card:hover .view-icon { transform: translateY(0); background: rgba(255,255,255,0.26); }

    .kelas-body {
        padding: 16px 18px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
    }

    .kelas-name {
        font-size: 15.5px;
        font-weight: 600;
        color: var(--pk-dark);
        letter-spacing: -0.2px;
        line-height: 1.3;
    }

    .kelas-code {
        font-size: 10.5px;
        color: var(--pk-blue);
        font-weight: 600;
        background: rgba(74, 143, 199, 0.10);
        padding: 3px 12px;
        border-radius: 50px;
        letter-spacing: 0.3px;
    }

    .kelas-footer {
        border-top: 1px solid var(--pk-border);
        padding: 12px 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        background: rgba(245, 248, 251, 0.6);
    }

    .kelas-metric {
        text-align: center;
        padding: 7px 6px;
        border-radius: 9px;
        transition: transform 0.2s var(--pk-ease);
    }
    .kelas-card:hover .kelas-metric { transform: translateY(-1px); }

    .kelas-metric .k-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        opacity: 0.75;
        margin-bottom: 3px;
    }
    .k-label svg { width: 10px; height: 10px; stroke: currentColor; flex-shrink: 0; }
    .kelas-metric .k-value {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .metric-murid { background: #eff6ff; color: #1d4ed8; }
    .metric-wali   { background: #faf5ff; color: #7c3aed; }

    /* ══════════════ PENGUMUMAN ══════════════ */
    .pk-announce {
        background: linear-gradient(135deg, var(--pk-dark) 0%, var(--pk-blue) 100%);
        border-radius: var(--pk-radius);
        padding: 34px 28px;
        text-align: center;
        box-shadow: var(--pk-shadow);
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    .pk-announce::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -10%;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    .pk-announce::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -8%;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .pk-announce-icon {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255,255,255,0.18);
        color: #ffd166;
        margin-bottom: 14px;
    }
    .pk-announce-icon svg { width: 26px; height: 26px; stroke: currentColor; }

    .pk-announce h3 {
        position: relative;
        z-index: 1;
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 8px;
        letter-spacing: -0.2px;
    }
    .pk-announce p {
        position: relative;
        z-index: 1;
        font-size: 13.5px;
        color: rgba(255,255,255,0.82);
        margin: 0;
        line-height: 1.6;
    }
    .pk-announce p strong { color: #fff; }
    .pk-announce .pk-announce-meta {
        position: relative;
        z-index: 1;
        font-size: 11.5px;
        margin-top: 10px;
        color: rgba(255,255,255,0.55);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .pk-announce-meta svg { width: 12px; height: 12px; stroke: currentColor; }

    /* ══════════════ EMPTY STATE ══════════════ */
    .pk-empty {
        text-align: center;
        padding: 64px 20px;
        background: var(--pk-white);
        border-radius: var(--pk-radius);
        border: 1.5px dashed var(--pk-border);
        margin-bottom: 36px;
    }
    .pk-empty svg { width: 48px; height: 48px; stroke: var(--pk-text-2); margin-bottom: 14px; }
    .pk-empty h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--pk-dark);
        margin: 0 0 6px;
    }
    .pk-empty p {
        font-size: 13px;
        color: var(--pk-text);
        margin: 0;
    }

    /* ══════════════ RESPONSIVE ══════════════ */
    @media (max-width: 768px) {
        .pk-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .pk-title { font-size: 20px; }
        .kelas-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
        .kelas-img { height: 122px; }
        .pk-stats { grid-template-columns: repeat(2, 1fr); }
        .pk-announce { padding: 26px 18px; }
    }

    @media (max-width: 480px) {
        .kelas-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .kelas-name { font-size: 13px; }
        .kelas-body { padding: 12px 10px 8px; }
        .kelas-footer { padding: 8px 10px; gap: 6px; }
        .kelas-metric .k-value { font-size: 11.5px; }
        .kelas-metric .k-label { font-size: 8px; }
        .pk-back-btn { width: 36px; height: 36px; }
        .pk-back-btn svg { width: 16px; height: 16px; }
        .pk-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
        .pk-stat-number { font-size: 18px; }
    }

    @media (max-width: 360px) {
        .kelas-grid { grid-template-columns: 1fr; }
    }

    /* ══════════════ ANIMASI ══════════════ */
    @keyframes pkFadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .kelas-card { animation: pkFadeUp 0.45s var(--pk-ease) both; }
    .kelas-card:nth-child(1)  { animation-delay: 0.02s; }
    .kelas-card:nth-child(2)  { animation-delay: 0.05s; }
    .kelas-card:nth-child(3)  { animation-delay: 0.08s; }
    .kelas-card:nth-child(4)  { animation-delay: 0.11s; }
    .kelas-card:nth-child(5)  { animation-delay: 0.14s; }
    .kelas-card:nth-child(6)  { animation-delay: 0.17s; }
    .kelas-card:nth-child(7)  { animation-delay: 0.20s; }
    .kelas-card:nth-child(8)  { animation-delay: 0.23s; }
    .kelas-card:nth-child(9)  { animation-delay: 0.26s; }
    .kelas-card:nth-child(10) { animation-delay: 0.29s; }
    .kelas-card:nth-child(11) { animation-delay: 0.32s; }
    .kelas-card:nth-child(12) { animation-delay: 0.35s; }

    .pk-announce { animation: pkFadeUp 0.5s var(--pk-ease) 0.15s both; }
    .pk-stat { animation: pkFadeUp 0.4s var(--pk-ease) both; }
    .pk-stat:nth-child(1) { animation-delay: 0.02s; }
    .pk-stat:nth-child(2) { animation-delay: 0.06s; }
    .pk-stat:nth-child(3) { animation-delay: 0.10s; }
</style>
@endsection

@section('content')

<div class="pk-wrap">

    {{-- ═══════ PAGE HEADER ═══════ --}}
    <div class="pk-header">
        <div class="pk-header-left">
            <a href="{{ route('guru.dashboard') }}" class="pk-back-btn" title="Kembali ke Dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div class="pk-title-group">
                <div class="pk-eyebrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V8l8-5 8 5v13"/><path d="M9 21v-6h6v6"/></svg>
                    Portal Guru
                </div>
                <h1 class="pk-title">Jenjang {{ $jenjang->nam ?? 'Tidak Diketahui' }}</h1>
                <div class="pk-subtitle">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 3v3M16 3v3"/></svg>
                    {{ $kelas->count() ?? 0 }} kelas yang kamu ajar tersedia
                </div>
            </div>
        </div>
        <span class="pk-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/></svg>
            {{ $jenjang->nam ?? 'Jenjang' }}
        </span>
    </div>

    {{-- ═══════ STATS ═══════ --}}
    <div class="pk-stats">
        <div class="pk-stat">
            <div class="pk-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21V5a2 2 0 012-2h8a2 2 0 012 2v16"/><path d="M13 21h6M9 8h.01M9 12h.01M9 16h.01"/></svg>
            </div>
            <div>
                <div class="pk-stat-number">{{ $kelas->count() ?? 0 }}</div>
                <div class="pk-stat-label">Total Kelas</div>
            </div>
        </div>
        <div class="pk-stat">
            <div class="pk-stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div>
                <div class="pk-stat-number">{{ $kelas->sum('jumlahsiswa_count') ?? 0 }}</div>
                <div class="pk-stat-label">Total Murid</div>
            </div>
        </div>
    </div>

    {{-- ═══════ GRID KELAS ═══════ --}}
    @if($kelas->count() > 0)
        <div class="pk-section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            <span>Daftar Kelas</span>
            <div class="line"></div>
        </div>

        <div class="kelas-grid">
            @foreach ($kelas as $k)
                @php
                    // SET DEFAULT FOTO = nullable.png
                    $imageUrl = asset('images/nullable.png');

                    // CEK APAKAH ADA FOTO DI DATABASE
                    if (!empty($k->foto)) {
                        $fotoPath = $k->foto;

                        $pathsToCheck = [
                            $fotoPath,
                            'images/' . $fotoPath,
                            'uploads/' . $fotoPath,
                            'foto/' . $fotoPath,
                            'storage/' . $fotoPath
                        ];

                        foreach ($pathsToCheck as $path) {
                            if (file_exists(public_path($path))) {
                                $imageUrl = asset($path);
                                break;
                            }
                        }
                        // Jika tidak ditemukan di lokasi manapun, tetap pakai nullable.png (default)
                    }
                @endphp

                <a href="{{ route('guru.detailkelas', ['id' => $k->id]) }}" class="kelas-card">
                    <div class="kelas-img">
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $k->nam ?? 'Kelas' }}"
                            loading="lazy"
                            onerror="this.src='{{ asset('images/nullable.png') }}'"
                        >
                        <div class="kelas-overlay">
                            <span class="view-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Detail
                            </span>
                        </div>
                    </div>
                    <div class="kelas-body">
                        <div class="kelas-name">{{ $k->nam ?? 'Kelas' }}</div>
                        @if(isset($k->kode))
                            <span class="kelas-code">{{ $k->kode }}</span>
                        @endif
                    </div>
                    <div class="kelas-footer">
                        <div class="kelas-metric metric-murid">
                            <div class="k-label">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Murid
                            </div>
                            <div class="k-value">{{ $k->jumlahsiswa_count ?? 0 }}</div>
                        </div>
                        <div class="kelas-metric metric-wali">
                            <div class="k-label">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M17 11l2 2 4-4"/></svg>
                                Wali
                            </div>
                            <div class="k-value">{{ optional($k->waliKelas)->nam ?? '-' }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        {{-- ═══════ EMPTY STATE ═══════ --}}
        <div class="pk-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 14px;display:block;"><path d="M3 7h5l2 3h11v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
            <h4>Belum Ada Kelas</h4>
            <p>Belum terdapat kelas pada jenjang ini. Silakan cek kembali nanti.</p>
        </div>
    @endif

    {{-- ═══════ PENGUMUMAN ═══════ --}}
    <div class="pk-announce">
        <div class="pk-announce-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        </div>
        <h3>Pengumuman & Informasi</h3>
        <p>
            Selamat datang di <strong>Sekolah TOS</strong>
            @if(isset($jenjang->nam))
                &mdash; Jenjang <strong>{{ $jenjang->nam }}</strong>
            @endif
        </p>
        <div class="pk-announce-meta">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Informasi terbaru akan diperbarui secara berkala
        </div>
    </div>

</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Smooth entrance animation untuk cards (fallback JS, CSS animation sudah cover sebagian besar)
        $('.kelas-card').each(function (i) {
            const el = $(this);
            if (el.css('opacity') === '0') {
                setTimeout(() => {
                    el.css({ opacity: 1, transform: 'translateY(0)' });
                }, i * 30);
            }
        });
    });
</script>
@endsection