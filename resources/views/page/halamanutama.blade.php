@extends('layouts.app')

@section('title', 'Pilih Jenjang Sekolah')

@section('styles')
<style>
    /* ── ROOT VARIABLES ── */
    :root {
        --primary-dark: #1a2a4a;
        --primary-blue: #2c5f8a;
        --primary-light: #4a8fc7;
        --primary-bg: #f0f4f8;
        --white: #ffffff;
        --gray-light: #e8edf2;
        --gray-text: #6b7a8f;
        --shadow-sm: 0 2px 8px rgba(26, 42, 74, 0.08);
        --shadow-hover: 0 8px 30px rgba(26, 42, 74, 0.15);
        --radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── PAGE HEADER ── */
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--gray-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 28px;
        font-weight: 600;
        color: var(--primary-dark);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .page-header .subtitle {
        font-size: 14px;
        color: var(--gray-text);
        font-weight: 400;
        margin-top: 4px;
    }

    .header-badge {
        background: var(--primary-blue);
        color: var(--white);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
    }

    /* ── STATS BAR ── */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-item {
        background: var(--white);
        padding: 16px 20px;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border-left: 4px solid var(--primary-light);
    }

    .stat-item .number {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .stat-item .label {
        font-size: 12px;
        color: var(--gray-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ── GRID ── */
    .jenjang-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    /* ── CARD ── */
    .j-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-light);
        position: relative;
    }

    .j-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-light);
    }

    .j-card:hover .j-arrow {
        opacity: 1;
        transform: translateX(4px);
    }

    /* top accent bar */
    .j-card::before {
        content: '';
        display: block;
        height: 4px;
        background: var(--primary-blue);
        border-radius: var(--radius) var(--radius) 0 0;
    }

    /* card body */
    .j-card-top {
        padding: 28px 24px 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex: 1;
    }

    .j-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(44, 95, 138, 0.08);
        transition: var(--transition);
    }

    .j-card:hover .j-icon-box {
        background: rgba(44, 95, 138, 0.15);
    }

    .j-icon-box i {
        font-size: 26px;
        color: var(--primary-blue);
        transition: var(--transition);
    }

    .j-card:hover .j-icon-box i {
        transform: scale(1.1);
    }

    .j-content {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .j-name {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-dark);
        letter-spacing: -0.3px;
        line-height: 1.3;
    }

    /* ── PERBAIKAN: JARAK LEBIH JAUH ANTARA PG DAN DESKRIPSI ── */
    .j-desc-wrapper {
        margin-top: 6px;
        padding-top: 12px;
        border-top: 1px dashed var(--gray-light);
    }

    .j-desc {
        font-size: 13px;
        color: var(--gray-text);
        line-height: 1.6;
        font-weight: 400;
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.2px;
        padding: 4px 0 2px;
    }

    /* badge untuk level */
    .j-level-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        color: var(--primary-blue);
        background: rgba(44, 95, 138, 0.08);
        padding: 2px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    /* card footer */
    .j-card-bottom {
        border-top: 1px solid var(--gray-light);
        padding: 14px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(240, 244, 248, 0.3);
    }

    .j-link-text {
        font-size: 13px;
        font-weight: 500;
        color: var(--primary-blue);
        font-family: 'Poppins', sans-serif;
        transition: var(--transition);
    }

    .j-card:hover .j-link-text {
        color: var(--primary-dark);
    }

    .j-arrow {
        font-size: 20px;
        color: var(--primary-blue);
        opacity: 0.4;
        transform: translateX(0);
        transition: var(--transition);
    }

    /* ── COLOR VARIANTS ── */
    .j-card.pg .j-icon-box i { color: #c0677c; }
    .j-card.pg .j-level-badge { color: #c0677c; background: rgba(192, 103, 124, 0.1); }
    .j-card.pg::before { background: #c0677c; }
    .j-card.pg .j-link-text { color: #c0677c; }
    .j-card.pg .j-arrow { color: #c0677c; }

    .j-card.sd .j-icon-box i { color: #6b7cb8; }
    .j-card.sd .j-level-badge { color: #6b7cb8; background: rgba(107, 124, 184, 0.1); }
    .j-card.sd::before { background: #6b7cb8; }
    .j-card.sd .j-link-text { color: #6b7cb8; }
    .j-card.sd .j-arrow { color: #6b7cb8; }

    .j-card.smp .j-icon-box i { color: #6a9b62; }
    .j-card.smp .j-level-badge { color: #6a9b62; background: rgba(106, 155, 98, 0.1); }
    .j-card.smp::before { background: #6a9b62; }
    .j-card.smp .j-link-text { color: #6a9b62; }
    .j-card.smp .j-arrow { color: #6a9b62; }

    .j-card.sma .j-icon-box i { color: #b8854f; }
    .j-card.sma .j-level-badge { color: #b8854f; background: rgba(184, 133, 79, 0.1); }
    .j-card.sma::before { background: #b8854f; }
    .j-card.sma .j-link-text { color: #b8854f; }
    .j-card.sma .j-arrow { color: #b8854f; }

    .j-card.smk .j-icon-box i { color: #a98fc2; }
    .j-card.smk .j-level-badge { color: #a98fc2; background: rgba(169, 143, 194, 0.1); }
    .j-card.smk::before { background: #a98fc2; }
    .j-card.smk .j-link-text { color: #a98fc2; }
    .j-card.smk .j-arrow { color: #a98fc2; }

    .j-card.def .j-icon-box i { color: #5f9d9b; }
    .j-card.def .j-level-badge { color: #5f9d9b; background: rgba(95, 157, 155, 0.1); }
    .j-card.def::before { background: #5f9d9b; }
    .j-card.def .j-link-text { color: #5f9d9b; }
    .j-card.def .j-arrow { color: #5f9d9b; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .page-header h1 {
            font-size: 22px;
        }

        .jenjang-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 14px;
        }

        .j-card-top {
            padding: 20px 18px 16px;
        }

        .j-card-bottom {
            padding: 12px 18px;
        }

        .stats-bar {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .jenjang-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .j-name {
            font-size: 15px;
        }

        .j-desc {
            font-size: 11px;
        }

        .j-icon-box {
            width: 40px;
            height: 40px;
        }

        .j-icon-box i {
            font-size: 20px;
        }

        .stats-bar {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-item .number {
            font-size: 18px;
        }
    }

    @media (max-width: 360px) {
        .jenjang-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .j-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .j-card:nth-child(1) { animation-delay: 0.05s; }
    .j-card:nth-child(2) { animation-delay: 0.10s; }
    .j-card:nth-child(3) { animation-delay: 0.15s; }
    .j-card:nth-child(4) { animation-delay: 0.20s; }
    .j-card:nth-child(5) { animation-delay: 0.25s; }
</style>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1>Pilih Jenjang Sekolah</h1>
        <div class="subtitle">Pilih jenjang pendidikan untuk melanjutkan</div>
    </div>
    <span class="header-badge">
        <i class='bx bxs-school'></i> {{ $jenjang->count() }} Jenjang
    </span>
</div>

<div class="jenjang-grid">
    @foreach ($jenjang as $j)
        @php
            $colorMap = ['1'=>'pg','2'=>'tk','3'=>'sd','4'=>'smp','5'=>'sma'];
$iconMap = [
    '1' => 'bxs-building-house',   // PG — gedung kecil
    '2' => 'bxs-school',           // TK
    '3' => 'bxs-school',           // SD
    '4' => 'bxs-institution',      // SMP — gedung institusi
    '5' => 'bxs-bank',             // SMA — gedung dengan pilar
];            $descMap  = [
                '1'=>'Pendidikan usia dini (PG)',
                '2'=>'Pendidikan usia dini (TK)',
                '3'=>'Pendidikan dasar 6 tahun (SD)',
                '4'=>'Menengah pertama (SMP)',
                '5'=>'Menengah atas (SMA)'
            ];
            $levelMap = ['1'=>'PAUD','2'=>'TK','3'=>'SD','4'=>'SMP','5'=>'SMA'];

            $cls  = $colorMap[$j->kod] ?? 'def';
            $icon = $iconMap[$j->kod]  ?? 'bxs-book';
            $desc = $descMap[$j->kod]  ?? 'Jenjang pendidikan';
            $level = $levelMap[$j->kod] ?? '';
        @endphp

            <a href="{{ route('guru.sekolah', ['tin' => $j->id]) }}" class="j-card {{ $cls }}">            
                <div class="j-card-top">
                <div class="j-icon-box">
                    <i class='bx {{ $icon }}'></i>
                </div>

                <div class="j-content">
                    <div class="j-name">
                        {{ strtoupper($j->nam) }}
                        <span class="j-level-badge">{{ $level }}</span>
                    </div>

                    <!-- PERBAIKAN: wrapper dengan padding-top dan border-top untuk jarak lebih jauh -->
                    <div class="j-desc-wrapper">
                        <div class="j-desc">
                            <i class='bx bx-info-circle' style="font-size:12px; opacity:0.6;"></i>
                            {{ $desc }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="j-card-bottom">
                <span class="j-link-text">
                    <i class='bx bx-right-arrow-alt' style="font-size:14px;"></i>
                    Lihat Sekolah
                </span>
                <i class='bx bx-chevron-right j-arrow'></i>
            </div>
        </a>
    @endforeach
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Smooth entrance animation sudah di-handle oleh CSS
        // Tambahan effect hover untuk interaktivitas ekstra
        $('.j-card').on('mouseenter', function() {
            $(this).find('.j-arrow').css({
                opacity: 1,
                transform: 'translateX(6px)'
            });
        });

        $('.j-card').on('mouseleave', function() {
            $(this).find('.j-arrow').css({
                opacity: 0.4,
                transform: 'translateX(0)'
            });
        });
    });
</script>
@endsection