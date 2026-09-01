<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISPRO — Sistem Informasi Sekolah Profesional')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN SYSTEM — TEMA PROFESIONAL INSTITUSI PENDIDIKAN (GURU)
           Sekarang pakai TOPBAR HORIZONTAL + TAB STRIP (ala Mai Admin),
           bukan sidebar kiri lagi.
           ============================================================ */
        :root {
            /* ── Warna Utama (tetap dipertahankan dari layout lama) ── */
            --primary-dark:    #0a1628;
            --primary-navy:    #1a2940;
            --primary-blue:    #1e4d8c;
            --primary-medium:  #2a6bb0;
            --primary-light:   #4a8fd4;
            --primary-lighter: #e8f0fe;
            --primary-white:   #ffffff;

            --accent-blue:     #0066cc;
            --accent-hover:    #004d99;
            --accent-soft:     rgba(30, 77, 140, 0.08);
            --accent-soft-strong: rgba(30, 77, 140, 0.14);

            /* ── Grayscale ── */
            --gray-900: #0f1a2b;
            --gray-800: #1a2a3f;
            --gray-700: #2c3d5a;
            --gray-600: #4a5a75;
            --gray-500: #6b7d96;
            --gray-400: #8fa2b8;
            --gray-300: #b8c8d9;
            --gray-200: #dce4ed;
            --gray-100: #f0f4f9;
            --gray-50:  #f8fafc;

            /* ── Semantic ── */
            --success: #0f7b3a;
            --success-bg: #e6f4ed;
            --warning: #b45f06;
            --warning-bg: #fef3e8;
            --danger: #b71c1c;
            --danger-bg: #fde8e8;
            --info: #0d6b8f;
            --info-bg: #e6f3f8;

            /* ── Spacing ── */
            --topbar-h:  60px;
            --radius:    10px;
            --radius-lg: 16px;
            --shadow-sm: 0 2px 8px rgba(10,22,40,0.06);
            --shadow-md: 0 6px 24px rgba(10,22,40,0.10);
            --shadow-lg: 0 12px 48px rgba(10,22,40,0.14);

            --font-family: 'Poppins', sans-serif;
        }

        /* ─── RESET ─────────────────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-family);
            font-size: 14px;
            background: var(--gray-50);
            color: var(--gray-800);
            margin: 0;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a { text-decoration: none; color: inherit; }

        [x-cloak] { display: none; }

        /* ─── SCROLLBAR ────────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }

        /* ══════════════ APP SHELL ══════════════ */
        .app-shell { display: flex; flex-direction: column; min-height: 100vh; }

        /* ══════════════ TOPBAR (horizontal, di atas) ══════════════ */
        #topbar {
            height: var(--topbar-h);
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-brand { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-blue));
            border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 15px; letter-spacing: -0.5px;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(30,77,140,0.4);
        }
        .brand-text { display: flex; flex-direction: column; line-height: 1.15; }
        .brand-name { font-size: 15px; font-weight: 700; color: var(--gray-900); letter-spacing: -0.2px; }
        .brand-sub {
            font-size: 9.5px; font-weight: 500; color: var(--gray-500);
            letter-spacing: 0.7px; text-transform: uppercase;
        }

        .mobile-menu-btn {
            display: none; width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--gray-200); background: #fff; color: var(--primary-blue);
            align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; font-size: 18px;
        }

        /* ── Horizontal nav ── */
        .main-nav { display: flex; align-items: center; gap: 2px; flex: 1; min-width: 0; }

        .nav-link, .nav-dropdown-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 13px;
            border-radius: 8px;
            border: none;
            background: none;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--gray-600);
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.13s, color 0.13s;
        }
        .nav-link i, .nav-dropdown-btn i.nav-icon { font-size: 17px; opacity: 0.75; flex-shrink: 0; }
        .nav-link:hover, .nav-dropdown-btn:hover { background: var(--accent-soft); color: var(--primary-blue); }
        .nav-link:hover i, .nav-dropdown-btn:hover i.nav-icon { opacity: 1; }
        .nav-link.active, .nav-dropdown-btn.active {
            background: var(--accent-soft-strong); color: var(--primary-blue); font-weight: 600;
        }
        .nav-link.active i, .nav-dropdown-btn.active i.nav-icon { opacity: 1; }

        .nav-link.is-disabled { cursor: pointer; opacity: 0.75; }

        .nav-badge {
            font-size: 9.5px; font-weight: 700; background: var(--danger); color: #fff;
            border-radius: 20px; padding: 1px 6px; line-height: 15px; flex-shrink: 0;
        }
        .nav-status {
            font-size: 8px; font-weight: 600; text-transform: uppercase;
            color: var(--gray-500); letter-spacing: 0.5px;
            background: var(--gray-100); padding: 1px 8px; border-radius: 20px; flex-shrink: 0;
        }

        .nav-dropdown-btn i.chevron { font-size: 13px; opacity: 0.55; transition: transform 0.15s; margin-left: -3px; }
        .nav-dropdown.is-open .nav-dropdown-btn i.chevron { transform: rotate(180deg); }

        .nav-dropdown { position: relative; }
        .nav-dropdown-panel {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            min-width: 210px;
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            box-shadow: var(--shadow-md);
            padding: 6px;
            z-index: 55;
        }
        .nav-dropdown.is-open .nav-dropdown-panel { display: block; }

        .nav-dropdown-panel a {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px; border-radius: 8px;
            font-size: 12.5px; font-weight: 500; color: var(--gray-600);
            text-decoration: none; transition: background 0.13s, color 0.13s;
        }
        .nav-dropdown-panel a i { font-size: 16px; opacity: 0.75; flex-shrink: 0; }
        .nav-dropdown-panel a:hover { background: var(--accent-soft); color: var(--primary-blue); }
        .nav-dropdown-panel a:hover i { opacity: 1; }
        .nav-dropdown-panel a.active { background: var(--accent-soft-strong); color: var(--primary-blue); font-weight: 600; }
        .nav-dropdown-panel a .nav-badge { margin-left: auto; }

        /* ── Right side of topbar ── */
        .topbar-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; margin-left: auto; }

        .topbar-btn {
            height: 34px; width: 34px; padding: 0; border-radius: 8px;
            border: 1px solid var(--gray-200); background: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; flex-shrink: 0; font-size: 17px; color: var(--gray-600);
            transition: all 0.13s;
        }
        .topbar-btn:hover { border-color: var(--primary-light); background: var(--accent-soft); color: var(--primary-blue); }
        .notif-dot {
            position: absolute; top: 6px; right: 6px; width: 6px; height: 6px;
            border-radius: 50%; background: var(--danger); border: 1.5px solid #fff;
        }

        .user-card {
            display: flex; align-items: center; gap: 9px;
            padding: 4px 10px 4px 4px; border-radius: 20px;
            border: 1px solid var(--gray-200);
            cursor: pointer; transition: background 0.13s;
            flex-shrink: 0;
        }
        .user-card:hover { background: var(--accent-soft); }
        .user-avatar {
            width: 27px; height: 27px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-blue));
            display: flex; align-items: center; justify-content: center;
            font-size: 10.5px; font-weight: 700; color: #fff; flex-shrink: 0; text-transform: uppercase;
        }
        .user-meta { display: flex; flex-direction: column; line-height: 1.15; max-width: 130px; }
        .user-name {
            font-size: 11.5px; font-weight: 600; color: var(--gray-800);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-role { font-size: 9.5px; color: var(--gray-500); }
        .logout-btn { background: none; border: none; cursor: pointer; color: var(--gray-400); padding: 2px; display: flex; font-size: 15px; }
        .logout-btn:hover { color: var(--primary-blue); }

        /* ══════════════ TAB STRIP (Chrome-like) ══════════════ */
        .tabstrip-wrap {
            background: var(--primary-lighter);
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: var(--topbar-h);
            z-index: 850;
        }
        .tabstrip {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            padding: 8px 16px 0;
            overflow-x: auto;
            scrollbar-width: thin;
        }
        .tabstrip::-webkit-scrollbar { height: 4px; }

        .tab-chip {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 10px 9px 14px;
            background: rgba(255,255,255,0.6);
            border: 1px solid transparent;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            font-size: 12px; font-weight: 500; color: var(--gray-600);
            cursor: pointer;
            max-width: 190px;
            flex-shrink: 0;
            transition: background 0.13s, color 0.13s;
            position: relative;
            top: 1px;
        }
        .tab-chip:hover { background: rgba(255,255,255,0.9); color: var(--gray-900); }
        .tab-chip.is-active {
            background: #fff;
            color: var(--gray-900);
            font-weight: 600;
            border-color: var(--gray-200);
            box-shadow: 0 -2px 8px -4px rgba(30,77,140,0.25);
        }
        .tab-chip.is-active::after {
            content: "";
            position: absolute; left: 0; right: 0; bottom: -1px; height: 2px;
            background: #fff;
        }
        .tab-chip-label { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tab-chip-close {
            width: 18px; height: 18px; border-radius: 5px; border: none; background: none;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            color: var(--gray-400); cursor: pointer; font-size: 13px;
        }
        .tab-chip-close:hover { background: var(--danger-bg); color: var(--danger); }

        /* ══════════════ CONTENT ══════════════ */
        .tab-pane { display: none; }
        .tab-pane.is-active { display: block; }

        #page-content { padding: 26px 32px 40px; flex: 1; }

        html.is-ajax-loading #page-content,
        #page-content.is-tab-loading {
            opacity: .55;
            filter: saturate(0.7);
            transition: opacity .15s ease, filter .15s ease;
            pointer-events: none;
        }

        /* ─── PAGE HEADER (dipakai halaman konten) ───────────────────── */
        .page-header {
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .page-title {
            font-size: 26px; font-weight: 700; color: var(--gray-900);
            letter-spacing: -0.5px; line-height: 1.2;
        }
        .page-title span { color: var(--primary-blue); }
        .page-subtitle { font-size: 13.5px; color: var(--gray-500); margin-top: 4px; font-weight: 400; }

        /* ─── STATS CARDS ───────────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: #fff; border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            padding: 22px 24px; display: flex; align-items: center; gap: 18px;
            transition: all 0.25s ease; box-shadow: var(--shadow-sm);
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: var(--primary-light); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;
        }
        .stat-icon.blue { background: var(--primary-lighter); color: var(--primary-blue); }
        .stat-icon.green { background: var(--success-bg); color: var(--success); }
        .stat-icon.orange { background: var(--warning-bg); color: var(--warning); }
        .stat-icon.purple { background: #ede7f6; color: #5e35b1; }
        .stat-icon.cyan { background: var(--info-bg); color: var(--info); }
        .stat-content { flex: 1; min-width: 0; }
        .stat-value { font-size: 24px; font-weight: 700; color: var(--gray-900); letter-spacing: -0.3px; line-height: 1.2; }
        .stat-label { font-size: 12.5px; color: var(--gray-500); font-weight: 400; margin-top: 2px; }
        .stat-change { font-size: 11.5px; font-weight: 600; display: flex; align-items: center; gap: 3px; margin-top: 4px; }
        .stat-change.up { color: var(--success); }
        .stat-change.down { color: var(--danger); }

        /* ─── CARDS ──────────────────────────────────────────────────── */
        .card-tos { background: #fff; border: 1px solid var(--gray-200); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: box-shadow 0.25s ease; }
        .card-tos:hover { box-shadow: var(--shadow-md); }
        .card-header-tos { padding: 18px 24px; border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; justify-content: space-between; }
        .card-header-tos h5 { font-size: 15px; font-weight: 600; color: var(--gray-900); margin: 0; }
        .card-body-tos { padding: 20px 24px; }

        /* ─── BUTTONS ────────────────────────────────────────────────── */
        .btn-primary-tos {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px;
            background: var(--primary-blue); color: #fff; border: none; border-radius: var(--radius);
            font-family: var(--font-family); font-size: 13.5px; font-weight: 600; cursor: pointer;
            transition: all 0.2s ease; box-shadow: 0 2px 12px rgba(30,77,140,0.3);
        }
        .btn-primary-tos:hover { background: var(--accent-hover); box-shadow: 0 4px 20px rgba(30,77,140,0.4); transform: translateY(-1px); color: #fff; }
        .btn-outline-tos {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px;
            background: transparent; color: var(--primary-blue); border: 1.5px solid var(--primary-blue);
            border-radius: var(--radius); font-family: var(--font-family); font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all 0.2s ease;
        }
        .btn-outline-tos:hover { background: var(--primary-blue); color: #fff; }
        .btn-ghost-tos {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
            background: transparent; color: var(--gray-600); border: 1px solid var(--gray-200);
            border-radius: var(--radius); font-family: var(--font-family); font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease;
        }
        .btn-ghost-tos:hover { background: var(--gray-50); border-color: var(--gray-300); }

        /* ─── TABLE ──────────────────────────────────────────────────── */
        .table-tos { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
        .table-tos thead th {
            font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
            color: var(--gray-500); padding: 12px 16px; border-bottom: 1.5px solid var(--gray-200); background: var(--gray-50);
        }
        .table-tos thead th:first-child { border-radius: var(--radius) 0 0 0; }
        .table-tos thead th:last-child { border-radius: 0 var(--radius) 0 0; }
        .table-tos tbody td { padding: 13px 16px; border-bottom: 1px solid var(--gray-100); color: var(--gray-700); vertical-align: middle; }
        .table-tos tbody tr:last-child td { border-bottom: none; }
        .table-tos tbody tr:hover td { background: var(--gray-50); }

        /* ─── BADGES ─────────────────────────────────────────────────── */
        .badge-tos { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
        .badge-tos.success { background: var(--success-bg); color: var(--success); }
        .badge-tos.warning { background: var(--warning-bg); color: var(--warning); }
        .badge-tos.danger { background: var(--danger-bg); color: var(--danger); }
        .badge-tos.info { background: var(--info-bg); color: var(--info); }
        .badge-tos.primary { background: var(--primary-lighter); color: var(--primary-blue); }

        /* ─── ALERT ──────────────────────────────────────────────────── */
        .alert-tos {
            padding: 14px 20px; border-radius: var(--radius); font-size: 13.5px;
            display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border: none;
        }
        .alert-tos.success { background: var(--success-bg); color: var(--success); }
        .alert-tos.danger { background: var(--danger-bg); color: var(--danger); }
        .alert-tos i { font-size: 20px; flex-shrink: 0; }

        /* ─── JENJANG CARDS ─────────────────────────────────────────── */
        .jenjang-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 16px; }
        .j-card {
            background: #fff; border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            overflow: hidden; text-decoration: none; display: flex; flex-direction: column;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); box-shadow: var(--shadow-sm);
        }
        .j-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); border-color: var(--primary-light); }
        .j-card::before { content: ''; display: block; height: 4px; background: var(--primary-blue); border-radius: 4px 4px 0 0; }
        .j-card.pg::before { background: #d4738a; }
        .j-card.sd::before  { background: #6b7cb8; }
        .j-card.smp::before { background: #6a9b62; }
        .j-card.sma::before { background: #b8854f; }
        .j-card.smk::before { background: #a98fc2; }
        .j-card-top { padding: 24px 20px 16px; display: flex; flex-direction: column; gap: 12px; flex: 1; }
        .j-icon-box { width: 48px; height: 48px; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; background: var(--primary-lighter); color: var(--primary-blue); }
        .j-card.pg .j-icon-box { background: #fce8ec; color: #d4738a; }
        .j-card.sd .j-icon-box  { background: #e8ecf8; color: #6b7cb8; }
        .j-card.smp .j-icon-box { background: #e8f4e6; color: #6a9b62; }
        .j-card.sma .j-icon-box { background: #f7ede4; color: #b8854f; }
        .j-card.smk .j-icon-box { background: #f2ecf8; color: #a98fc2; }
        .j-icon-box i { font-size: 24px; }
        .j-name { font-size: 16px; font-weight: 700; color: var(--gray-900); }
        .j-desc { font-size: 12px; color: var(--gray-500); line-height: 1.4; margin-top: -4px; }
        .j-card-bottom { border-top: 1px solid var(--gray-200); padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; }
        .j-link-text { font-size: 12px; font-weight: 600; color: var(--primary-blue); }
        .j-arrow { font-size: 18px; color: var(--gray-300); transition: all 0.25s ease; }
        .j-card:hover .j-arrow { color: var(--primary-blue); transform: translateX(4px); }

        /* ─── MODAL / TOAST "FITUR SEDANG DIKEMBANGKAN" ────────────── */
        .coming-soon-toast {
            position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) translateY(20px);
            background: var(--primary-dark); color: #fff; padding: 16px 32px; border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg); font-family: var(--font-family); font-size: 14px; font-weight: 500;
            z-index: 9999; opacity: 0; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none; display: flex; align-items: center; gap: 12px; border: 1px solid rgba(255,255,255,0.1);
        }
        .coming-soon-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); pointer-events: auto; }
        .coming-soon-toast i { font-size: 24px; color: #fbbf24; }
        .coming-soon-toast .close-toast { background: none; border: none; color: rgba(255,255,255,0.5); font-size: 20px; cursor: pointer; padding: 4px; margin-left: 8px; transition: color 0.2s; }
        .coming-soon-toast .close-toast:hover { color: #fff; }

        /* Utilities */
        .text-primary-dark { color: var(--primary-dark); }
        .text-primary-blue { color: var(--primary-blue); }
        .bg-primary-lighter { background: var(--primary-lighter); }
        .fw-600 { font-weight: 600; }
        .gap-2 { gap: 8px; } .gap-3 { gap: 12px; } .gap-4 { gap: 16px; }
        .mb-2 { margin-bottom: 8px; } .mb-3 { margin-bottom: 12px; } .mb-4 { margin-bottom: 20px; }
        .mt-2 { margin-top: 8px; } .mt-3 { margin-top: 12px; } .mt-4 { margin-top: 20px; }
        .d-flex { display: flex; } .align-center { align-items: center; } .justify-between { justify-content: space-between; }
        .flex-wrap { flex-wrap: wrap; } .flex-1 { flex: 1; } .min-w-0 { min-width: 0; }
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; margin: -4px -4px 0; padding: 4px; }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 900px) {
            .main-nav { display: none; }
            .main-nav.is-mobile-open {
                display: flex; flex-direction: column; align-items: stretch; gap: 2px;
                position: fixed; top: var(--topbar-h); left: 0; right: 0;
                background: #fff; border-bottom: 1px solid var(--gray-200);
                padding: 10px 12px 16px; max-height: calc(100vh - var(--topbar-h));
                overflow-y: auto; box-shadow: var(--shadow-md); z-index: 895;
            }
            .main-nav.is-mobile-open .nav-dropdown-panel {
                position: static; box-shadow: none; border: none; margin: 2px 0 2px 10px; padding: 0; display: none;
            }
            .main-nav.is-mobile-open .nav-dropdown.is-open .nav-dropdown-panel { display: block; }

            .mobile-menu-btn { display: flex; }
            #topbar { padding: 0 14px; gap: 10px; }
            .brand-sub { display: none; }
            .user-meta { display: none; }
            #page-content { padding: 18px 16px 32px; }
            .tabstrip { padding: 8px 10px 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .jenjang-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
        }

        @media (max-width: 576px) {
            #topbar { padding: 0 12px; }
            #page-content { padding: 16px 12px 32px; }
            .page-title { font-size: 20px; }
            .stat-card { padding: 16px 18px; }
            .stat-value { font-size: 20px; }
            .card-header-tos { padding: 14px 16px; flex-wrap: wrap; gap: 8px; }
            .card-body-tos { padding: 14px 16px; }
            .table-tos { font-size: 12px; }
            .table-tos thead th, .table-tos tbody td { padding: 10px 12px; }
            .topbar-actions .topbar-btn:nth-child(1) { display: none; }
            .coming-soon-toast { bottom: 20px; padding: 12px 20px; font-size: 13px; max-width: 90%; }
            .coming-soon-toast i { font-size: 20px; }
        }

        @yield('layout-styles')
    </style>

    @yield('styles')
</head>
<body>
<div class="app-shell">

    <!-- ─── TOAST "FITUR SEDANG DIKEMBANGKAN" ──────────────────── -->
    <div class="coming-soon-toast" id="comingSoonToast">
        <i class='bx bx-code-alt'></i>
        <span>⚠️ Fitur ini sedang dalam tahap pengembangan</span>
        <button class="close-toast" id="closeToast">
            <i class='bx bx-x'></i>
        </button>
    </div>

    {{-- ═══════════ TOPBAR (horizontal, di atas) ═══════════ --}}
    <header id="topbar">
        <a href="{{ route('guru.dashboard') }}" class="topbar-brand" data-tab-link data-label="Pilih Jenjang">
            <div class="brand-logo">SP</div>
            <div class="brand-text">
                <span class="brand-name">TOS</span>
                <span class="brand-sub">Sistem Informasi Sekolah</span>
            </div>
        </a>

        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" title="Buka menu">
            <i class='bx bx-menu'></i>
        </button>

        <nav class="main-nav" id="mainNav">

            <a href="{{ route('guru.dashboard') }}" data-tab-link data-label="Pilih Jenjang"
               class="nav-link {{ request()->routeIs('guru.dashboard*') ? 'active' : '' }}">
                <i class='bx bx-buildings'></i>
                <span>Pilih Jenjang</span>
            </a>

            <a href="javascript:void(0)" class="nav-link is-disabled coming-soon" data-feature="Ujian">
                <i class='bx bx-notepad'></i>
                <span>Ujian</span>
                <span class="nav-status">Segera</span>
            </a>

            <a href="javascript:void(0)" class="nav-link is-disabled coming-soon" data-feature="Nilai">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span>Nilai</span>
                <span class="nav-status">Segera</span>
            </a>

            <a href="javascript:void(0)" class="nav-link is-disabled coming-soon" data-feature="Absensi">
                <i class='bx bx-calendar-check'></i>
                <span>Absensi</span>
                <span class="nav-status">Segera</span>
            </a>

        </nav>

        <div class="topbar-actions">
            <button class="topbar-btn" title="Cari" aria-label="Cari">
                <i class='bx bx-search'></i>
            </button>
            <button class="topbar-btn" title="Notifikasi" aria-label="Notifikasi">
                <i class='bx bx-bell'></i>
                <span class="notif-dot"></span>
            </button>

@php
    // Ambil data user dari Takunguru
    $user = Auth::guard('guru')->user();

    // Ambil data guru dari relasi (Karyawan)
    $guru = $user ? $user->guru : null;

    // Nama: dari Karyawan.Nam, fallback ke username
    $name = $guru ? ($guru->Nam ?? $user->username) : ($user->username ?? 'Administrator');

    // Tidak ada kolom role khusus di tkaryawan — pakai default
    $role = 'Guru';

    // Inisial untuk avatar
    $initial = strtoupper(substr($name, 0, 2));
@endphp
            <div class="user-card">
                <div class="user-avatar">{{ $initial }}</div>
                <div class="user-meta">
                    <div class="user-name">{{ $name }}</div>
                    <div class="user-role">{{ $role }}</div>
                </div>

                <!-- ✅ Logout via form POST -->
                <form action="{{ route('guru.logout') }}" method="POST" style="margin: 0; line-height: 0;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class='bx bx-log-out'></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ═══════════ TAB STRIP (Chrome-like) ═══════════ --}}
    <div class="tabstrip-wrap">
        <div class="tabstrip" id="tabStrip"></div>
    </div>

    {{-- ═══════════ CONTENT ═══════════ --}}
    <div id="ajax-content">
        <main id="page-content">
            @if(session('success'))
                <div class="alert-tos success">
                    <i class='bx bx-check-circle'></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-tos danger">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        @yield('script')
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
(function () {
    const tabStripEl       = document.getElementById('tabStrip');
    const contentContainer = document.getElementById('ajax-content');
    const mobileMenuBtn    = document.getElementById('mobileMenuBtn');
    const mainNav          = document.getElementById('mainNav');

    /* ───────── Dropdown menu (kalau nanti ada nav-dropdown) ───────── */
    document.querySelectorAll('.nav-dropdown > .nav-dropdown-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const parent = btn.closest('.nav-dropdown');
            const wasOpen = parent.classList.contains('is-open');
            document.querySelectorAll('.nav-dropdown.is-open').forEach(function (d) { d.classList.remove('is-open'); });
            if (!wasOpen) parent.classList.add('is-open');
        });
    });
    document.addEventListener('click', function () {
        document.querySelectorAll('.nav-dropdown.is-open').forEach(function (d) { d.classList.remove('is-open'); });
    });

    mobileMenuBtn && mobileMenuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        mainNav.classList.toggle('is-mobile-open');
    });

    /* ───────── Coming Soon Toast ───────── */
    const toast = document.getElementById('comingSoonToast');
    const closeToast = document.getElementById('closeToast');
    let toastTimeout = null;

    function showComingSoon(featureName) {
        const message = toast.querySelector('span');
        message.textContent = featureName
            ? `⚠️ Fitur "${featureName}" sedang dalam tahap pengembangan`
            : '⚠️ Fitur ini sedang dalam tahap pengembangan';

        toast.classList.add('show');
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
    }

    closeToast?.addEventListener('click', (e) => {
        e.stopPropagation();
        toast.classList.remove('show');
        clearTimeout(toastTimeout);
    });

    document.addEventListener('click', (e) => {
        if (toast.classList.contains('show') && !toast.contains(e.target)) {
            toast.classList.remove('show');
            clearTimeout(toastTimeout);
        }
    });

    document.body.addEventListener('click', function (e) {
        const el = e.target.closest('.coming-soon');
        if (!el) return;
        e.preventDefault();
        e.stopPropagation();
        showComingSoon(el.dataset.feature || 'ini');
        mainNav.classList.remove('is-mobile-open');
    });

    /* ───────── Tab manager v2 ─────────
       - Setiap tab punya "pane" (div) sendiri yang beneran nempel di DOM.
       - Pindah tab = sembunyiin/nampilin pane (display:none / block),
         BUKAN replace innerHTML dari string cache, jadi input yang lagi
         diketik user di tab non-aktif tidak hilang.
       - Hanya loadInPlace() (klik link/tombol Tambah/Edit/pagination
         DI DALAM konten, atau ganti url di tab yang sama) yang fetch ulang
         & replace isi pane, karena itu memang "halaman baru" di tab yg sama.
    */
    let tabs      = [];   // { id, url, title, docTitle, pinned, loaded, pane }
    let fetching  = {};   // tabId -> bool
    let activeId  = null;
    let counter   = 0;

    function urlKey(url) {
        try { return new URL(url, window.location.href).href; } catch (e) { return url; }
    }

    function runScripts(container) {
        container.querySelectorAll('script').forEach(function (oldScript) {
            const newScript = document.createElement('script');
            for (const attr of oldScript.attributes) newScript.setAttribute(attr.name, attr.value);
            newScript.textContent = oldScript.textContent;
            oldScript.replaceWith(newScript);
        });
    }

    function setActiveNavLink(pathname) {
        document.querySelectorAll('[data-tab-link]').forEach(function (link) {
            let linkPath;
            try { linkPath = new URL(link.getAttribute('href'), window.location.href).pathname; }
            catch (e) { return; }
            link.classList.toggle('active', linkPath === pathname);
        });
    }

    function renderTabStrip() {
        tabStripEl.innerHTML = '';
        tabs.forEach(function (tab) {
            const el = document.createElement('div');
            el.className = 'tab-chip' + (tab.id === activeId ? ' is-active' : '');

            const label = document.createElement('span');
            label.className = 'tab-chip-label';
            label.textContent = tab.title;
            el.appendChild(label);

            if (!tab.pinned) {
                const closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'tab-chip-close';
                closeBtn.title = 'Tutup tab';
                closeBtn.innerHTML = '<i class="bx bx-x"></i>';
                closeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    closeTab(tab.id);
                });
                el.appendChild(closeBtn);
            }

            el.addEventListener('click', function () { activateTab(tab.id); });
            tabStripEl.appendChild(el);
        });
    }

    function createPane() {
        const pane = document.createElement('div');
        pane.className = 'tab-pane';
        contentContainer.appendChild(pane);
        return pane;
    }

    function showPane(tab) {
        tabs.forEach(function (t) {
            if (t.pane) {
                t.pane.style.display = (t.id === tab.id) ? 'block' : 'none';
                t.pane.classList.toggle('is-active', t.id === tab.id);
            }
        });
        if (tab.docTitle) document.title = tab.docTitle;
        setActiveNavLink(new URL(tab.url, window.location.href).pathname);
    }

    function setPaneLoading(tab, isLoading) {
        if (!tab.pane) return;
        const inner = tab.pane.querySelector('#page-content') || tab.pane;
        inner.classList.toggle('is-tab-loading', isLoading);
    }

    function activateTab(id) {
        const tab = tabs.find(function (t) { return t.id === id; });
        if (!tab) return;
        activeId = id;
        renderTabStrip();
        if (tab.loaded) {
            showPane(tab);
            history.replaceState({ tabId: id }, '', tab.url);
        } else {
            fetchIntoPane(tab, true);
        }
    }

    function closeTab(id) {
        const idx = tabs.findIndex(function (t) { return t.id === id; });
        if (idx === -1) return;
        const wasActive = activeId === id;
        const tab = tabs[idx];
        if (tab.pane) tab.pane.remove();
        tabs.splice(idx, 1);

        if (wasActive) {
            const next = tabs[idx - 1] || tabs[idx] || tabs[0];
            if (next) activateTab(next.id);
            else { activeId = null; renderTabStrip(); }
        } else {
            renderTabStrip();
        }
    }

    function fetchIntoPane(tab, thenShow) {
        if (fetching[tab.id]) return;
        fetching[tab.id] = true;
        if (!tab.pane) tab.pane = createPane();
        setPaneLoading(tab, true);

        fetch(tab.url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (res) {
                if (!res.ok) throw new Error('Gagal memuat halaman (' + res.status + ')');
                return res.text();
            })
            .then(function (html) {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newContent = doc.getElementById('ajax-content');
                if (!newContent) { window.location.href = tab.url; return; }

                const title = doc.title || document.title;
                tab.pane.innerHTML = newContent.innerHTML;
                runScripts(tab.pane);

                tab.docTitle = title;
                tab.title = title.split(' — ')[0].trim() || tab.title;
                tab.loaded = true;
                renderTabStrip();

                if (thenShow && activeId === tab.id) {
                    showPane(tab);
                    history.replaceState({ tabId: tab.id }, '', tab.url);
                }
            })
            .catch(function (err) {
                console.error('Gagal membuka tab:', err);
                window.location.href = tab.url;
            })
            .finally(function () {
                fetching[tab.id] = false;
                setPaneLoading(tab, false);
            });
    }

    function openTab(url, title) {
        const key = urlKey(url);
        const existing = tabs.find(function (t) { return urlKey(t.url) === key; });
        if (existing) { activateTab(existing.id); return; }

        counter += 1;
        const tab = { id: 'tab-' + counter, url: url, title: title || 'Memuat…', pinned: false, loaded: false, pane: null };
        tabs.push(tab);
        activeId = tab.id;
        renderTabStrip();

        history.pushState({ tabId: tab.id }, '', url);
        fetchIntoPane(tab, true);
    }

    /**
     * Muat URL BARU di DALAM tab yang lagi aktif (bukan bikin tab baru).
     * Dipakai untuk link/form yang ada di dalam konten halaman
     * (Tambah, Detail, Edit, pagination, search, dst).
     */
    function loadInPlace(url) {
        const activeTab = tabs.find(function (t) { return t.id === activeId; });
        if (!activeTab) { window.location.href = url; return; }

        activeTab.url = url;
        activeTab.loaded = false;
        fetchIntoPane(activeTab, true);
    }

    /* Klik link menu (topbar) → buka/pindah TAB BARU */
    document.addEventListener('click', function (e) {
        const link = e.target.closest('[data-tab-link]');
        if (!link) return;
        if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

        e.preventDefault();
        openTab(link.href, link.dataset.label || link.textContent.trim());

        document.querySelectorAll('.nav-dropdown.is-open').forEach(function (d) { d.classList.remove('is-open'); });
        mainNav.classList.remove('is-mobile-open');
    });

    /* Klik link BIASA di dalam konten (tombol "Detail", link pagination, dsb)
       → tetap di tab yang sama. */
    document.addEventListener('click', function (e) {
        if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        const link = e.target.closest('a[href]');
        if (!link) return;
        if (link.closest('[data-tab-link]')) return;
        if (link.hasAttribute('data-no-ajax')) return;
        if (link.closest('[data-no-ajax]')) return;
        if (link.target && link.target !== '_self') return;
        if (link.hasAttribute('download')) return;
        if (!link.closest('.tab-pane.is-active')) return;

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') ||
            href.startsWith('mailto:') || href.startsWith('tel:')) return;

        let url;
        try { url = new URL(href, window.location.href); } catch (err) { return; }
        if (url.origin !== window.location.origin) return;

        e.preventDefault();
        loadInPlace(url.href);
    });

    /* Submit form GET di dalam konten (search & filter) → in-place juga */
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (form.hasAttribute('data-no-ajax')) return;
        if (form.closest('[data-no-ajax]')) return;
        if ((form.method || 'get').toLowerCase() !== 'get') return;
        if (!form.closest('.tab-pane.is-active')) return;

        e.preventDefault();
        const action = form.getAttribute('action') || window.location.href;
        const url = new URL(action, window.location.href);
        url.search = new URLSearchParams(new FormData(form)).toString();
        loadInPlace(url.href);
    });

    window.addEventListener('popstate', function () {
        const url = window.location.href;
        const existing = tabs.find(function (t) { return urlKey(t.url) === urlKey(url); });
        if (existing) { activateTab(existing.id); return; }
        if (activeId) { loadInPlace(url); return; }
        openTab(url, document.title.split(' — ')[0].trim());
    });

    (function initHomeTab() {
        counter += 1;
        const pane = document.createElement('div');
        pane.className = 'tab-pane is-active';
        pane.style.display = 'block';

        // Pindahkan semua child yang ada ke pane
        while (contentContainer.firstChild) {
            pane.appendChild(contentContainer.firstChild);
        }

        contentContainer.appendChild(pane);

        const homeTab = {
            id: 'tab-' + counter,
            url: window.location.href,
            title: document.title.split(' — ')[0].trim() || 'Pilih Jenjang',
            docTitle: document.title,
            pinned: true,
            loaded: true,
            pane: pane
        };
        tabs.push(homeTab);
        activeId = homeTab.id;
        renderTabStrip();
        setActiveNavLink(window.location.pathname);
        history.replaceState({ tabId: homeTab.id }, '', window.location.href);
    })();
})();
</script>

</body>
</html>