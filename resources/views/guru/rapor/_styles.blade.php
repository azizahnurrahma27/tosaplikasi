{{-- resources/views/rapor/_styles.blade.php --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --bg: #F5F6FA;
        --surface: #FFFFFF;
        --border: #E4E7EC;
        --text: #1D2433;
        --muted: #6B7280;
        --primary: #2F6FED;
        --primary-dark: #2457C4;
        --primary-soft: #EAF1FF;
        --danger: #E5484D;
        --radius: 12px;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        background: var(--bg);
        color: var(--text);
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    .page {
        max-width: 720px;
        margin: 0 auto;
        padding: 32px 20px 64px;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--muted);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    .back-link:hover { color: var(--text); }

    .title-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
    }

    .title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .badge-kelas {
        font-size: 13px;
        font-weight: 700;
        color: var(--primary-dark);
        background: var(--primary-soft);
        border-radius: 999px;
        padding: 4px 12px;
        white-space: nowrap;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
    }

    /* --- list halaman RAPOR --- */
    .siswa-list { list-style: none; margin: 0; padding: 0; }

    .siswa-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        color: var(--text);
        transition: background 0.12s ease;
    }
    .siswa-item:last-child { border-bottom: none; }
    .siswa-item:hover { background: #FAFBFF; }

    .siswa-num {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        border-radius: 8px;
        background: var(--primary-soft);
        color: var(--primary-dark);
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .siswa-name { flex: 1; font-weight: 600; font-size: 15px; }

    .siswa-status {
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 999px;
    }
    .status-ada { background: #E7F8EE; color: #17803D; }
    .status-belum { background: #F4F4F5; color: #6B7280; }

    .chevron { color: #C7CBD4; font-size: 18px; }

    .empty-state {
        text-align: center;
        padding: 56px 20px;
        color: var(--muted);
        font-size: 14px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-family: inherit;
        font-weight: 600;
        font-size: 14px;
        border-radius: 10px;
        padding: 10px 18px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: var(--primary-dark); }
    .btn-ghost { background: transparent; color: var(--text); border-color: var(--border); }
    .btn-ghost:hover { background: #F2F3F5; }
    .btn-danger-ghost { background: transparent; color: var(--danger); border-color: var(--border); }
    .btn-danger-ghost:hover { background: #FEECEC; }
    .btn-sm { padding: 6px 12px; font-size: 13px; border-radius: 8px; }

    /* --- form halaman UPLOAD RAPOR --- */
    .form-card { padding: 28px; }

    .field { margin-bottom: 20px; }

    .label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text);
    }

    .input, .select, .textarea {
        width: 100%;
        font-family: inherit;
        font-size: 14px;
        color: var(--text);
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 12px;
    }
    .input:focus, .select:focus, .textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-soft);
    }
    .textarea { resize: vertical; min-height: 160px; }

    .upload-box {
        border: 1.5px dashed var(--border);
        border-radius: var(--radius);
        padding: 24px;
        text-align: center;
        background: #FAFBFC;
    }
    .upload-box input[type="file"] {
        font-family: inherit;
        font-size: 13px;
    }
    .upload-current {
        margin-top: 10px;
        font-size: 13px;
        color: var(--muted);
    }
    .upload-current a { color: var(--primary); font-weight: 600; text-decoration: none; }

    .help-text { font-size: 12px; color: var(--muted); margin-top: 6px; }

    .invalid { border-color: var(--danger) !important; }
    .error-text { font-size: 12px; color: var(--danger); margin-top: 6px; }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
    }

    .alert {
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        margin-bottom: 18px;
    }
    .alert-success { background: #E7F8EE; color: #17803D; }
    .alert-danger { background: #FEECEC; color: #B42318; }
    .alert ul { margin: 0; padding-left: 18px; }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }
    .filter-bar input, .filter-bar select {
        font-family: inherit;
        font-size: 13px;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 10px;
        background: #fff;
    }
</style>