<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Hari Ini — {{ $isikelas->nam ?? 'Kelas' }}</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== CSS Variables ===== */
        :root {
            --primary-dark: #1a2a4a;
            --primary-blue: #2c5f8a;
            --primary-light: #4a8fc7;
            --primary-bg: #f0f4f8;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

            /* Status colors */
            --c-ok: #027a48;
            --c-ok-bg: #ecfdf3;
            --c-warn: #b54708;
            --c-warn-bg: #fffaeb;
            --c-danger: #b42318;
            --c-danger-bg: #fef3f2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            line-height: 1.6;
            font-size: 14px;
        }

        .wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .top-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem 0;
            flex-wrap: wrap;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 50px;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.875rem;
            font-family: var(--font-family);
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--white);
        }

        .btn-back i {
            font-size: 1.2rem;
            line-height: 1;
        }

        .top-nav-title {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--gray-500);
            margin-left: 0.5rem;
        }

        .top-nav-title span {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .top-nav-badge {
            margin-left: auto;
            background: var(--primary-bg);
            color: var(--primary-blue);
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 30px rgba(44, 95, 138, 0.30);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: 5%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
            flex-wrap: wrap;
        }

        .page-header-left {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            color: var(--white);
        }

        .page-eyebrow {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0;
        }

        .page-title span {
            opacity: 0.9;
        }

        .page-sub {
            font-size: 0.95rem;
            opacity: 0.85;
            font-weight: 400;
            margin: 0;
        }

        .date-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--white);
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .date-badge i {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .summary-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--white);
            border: 1px solid var(--gray-200);
            color: var(--gray-600);
            box-shadow: var(--shadow-sm);
            font-family: var(--font-family);
        }

        .chip.brand {
            background: var(--primary-bg);
            border-color: var(--primary-light);
            color: var(--primary-blue);
        }

        .chip i {
            font-size: 1.1rem;
        }

        .filter-bar {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
            box-shadow: var(--shadow-sm);
        }

        .fg {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            flex: 1;
            min-width: 150px;
        }

        .fg label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-family: var(--font-family);
        }

        .fg select,
        .fg input[type="date"] {
            height: 42px;
            padding: 0 0.8rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 0.9rem;
            color: var(--gray-800);
            background: var(--gray-50);
            font-family: var(--font-family);
            outline: none;
            width: 100%;
            transition: var(--transition);
        }

        .fg select:focus,
        .fg input[type="date"]:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.12);
            background: var(--white);
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            height: 42px;
            padding: 0 1.25rem;
            border: none;
            border-radius: var(--radius);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: var(--font-family);
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background: var(--primary-blue);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-ghost {
            background: var(--gray-50);
            color: var(--gray-600);
            border: 1px solid var(--gray-200);
        }

        .btn-ghost:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .btn-danger {
            background: var(--c-danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #8f1c12;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-sm {
            height: 32px;
            padding: 0 0.8rem;
            font-size: 0.75rem;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            min-width: 700px;
        }

        thead {
            background: var(--primary-dark);
        }

        th {
            padding: 0.8rem 1rem;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
            font-family: var(--font-family);
        }

        td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:hover td {
            background: var(--gray-50);
        }

        .td-no {
            color: var(--gray-400);
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            width: 3rem;
        }

        .siswa-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-bg);
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--gray-200);
            text-transform: uppercase;
            font-family: var(--font-family);
        }

        .siswa-name {
            font-weight: 600;
            color: var(--gray-800);
            display: block;
            font-size: 0.9rem;
        }

        .siswa-nis {
            font-size: 0.7rem;
            color: var(--gray-400);
            font-family: 'SFMono-Regular', Consolas, monospace;
        }

        .badge-jenis {
            display: inline-block;
            padding: 0.2rem 0.8rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--primary-bg);
            color: var(--primary-blue);
            border: 1px solid var(--gray-200);
            font-family: var(--font-family);
        }

        /* ===== Badge Status ===== */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.8rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            font-family: var(--font-family);
            white-space: nowrap;
        }

        .badge-status-pending {
            background: var(--c-warn-bg);
            color: var(--c-warn);
        }

        .badge-status-approved {
            background: var(--c-ok-bg);
            color: var(--c-ok);
        }

        .badge-status-rejected {
            background: var(--c-danger-bg);
            color: var(--c-danger);
        }

        .badge-status-exited {
            background: var(--gray-100);
            color: var(--gray-500);
        }

        .alasan-tolak {
            font-size: 0.7rem;
            color: var(--c-danger);
            margin-top: 3px;
            max-width: 160px;
        }

        .aksi-cell {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .diproses-info {
            font-size: 0.68rem;
            color: var(--gray-400);
            font-style: italic;
        }

        /* ===== Modal Tolak ===== */
        dialog.modal-tolak {
            border: none;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            max-width: 380px;
            width: 90%;
            box-shadow: var(--shadow-lg);
            font-family: var(--font-family);
        }

        dialog.modal-tolak::backdrop {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
        }

        .modal-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .modal-textarea {
            width: 100%;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 0.7rem;
            font-family: var(--font-family);
            font-size: 0.85rem;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 1rem;
            outline: none;
        }

        .modal-textarea:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.12);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .tgl-main {
            font-weight: 500;
            white-space: nowrap;
            font-size: 0.85rem;
        }

        .tgl-range {
            font-size: 0.7rem;
            color: var(--gray-500);
            margin-top: 2px;
            white-space: nowrap;
        }

        .tgl-range i {
            font-size: 0.7rem;
            vertical-align: -1px;
        }

        .dur-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.1rem 0.5rem;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 3px;
            font-family: var(--font-family);
        }

        .dur-1 {
            background: var(--c-ok-bg);
            color: var(--c-ok);
        }

        .dur-gt {
            background: var(--c-warn-bg);
            color: var(--c-warn);
        }

        .ket-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 200px;
            word-break: break-word;
            color: var(--gray-600);
            font-size: 0.8rem;
        }

        .lamp-link {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--primary-blue);
            text-decoration: none;
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius);
            background: var(--primary-bg);
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            font-family: var(--font-family);
        }

        .lamp-link:hover {
            background: var(--gray-200);
            color: var(--primary-dark);
        }

        .lamp-link i {
            font-size: 0.9rem;
        }

        .lamp-size {
            font-size: 0.6rem;
            color: var(--gray-400);
            font-weight: 400;
        }

        .lamp-none {
            font-size: 0.75rem;
            color: var(--gray-400);
            font-style: italic;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1.5rem;
            color: var(--gray-500);
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--gray-50);
            border: 1.5px solid var(--gray-200);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .empty-icon i {
            font-size: 28px;
            color: var(--gray-400);
        }

        .empty-state h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.35rem;
            font-family: var(--font-family);
        }

        .empty-state p {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .empty-state p strong {
            color: var(--gray-700);
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
            gap: 0.75rem;
            background: var(--gray-50);
        }

        .pagi-info {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .pagi-info strong {
            color: var(--gray-700);
        }

        .pagi-links {
            display: flex;
            gap: 0.25rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagi-links a,
        .pagi-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: var(--radius);
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid var(--gray-200);
            color: var(--gray-600);
            text-decoration: none;
            transition: var(--transition);
            font-family: var(--font-family);
            padding: 0 0.5rem;
        }

        .pagi-links a:hover {
            background: var(--primary-bg);
            border-color: var(--primary-light);
            color: var(--primary-blue);
        }

        .pagi-links span.active {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: var(--white);
            font-weight: 700;
        }

        .pagi-links span.disabled {
            opacity: 0.35;
            cursor: default;
        }

        /* ===== Responsive ===== */

        @media (max-width: 1024px) {
            .wrap {
                padding: 1.25rem;
            }

            .page-header {
                padding: 1.75rem 2rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .wrap {
                padding: 1rem;
            }

            .top-nav {
                gap: 0.75rem;
            }

            .top-nav-title {
                font-size: 0.85rem;
                width: 100%;
                margin-left: 0;
            }

            .top-nav-badge {
                margin-left: 0;
                font-size: 0.7rem;
                padding: 0.2rem 0.8rem;
            }

            .page-header {
                padding: 1.5rem 1.25rem;
                border-radius: var(--radius-lg);
            }

            .page-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .page-sub {
                font-size: 0.85rem;
            }

            .date-badge {
                font-size: 0.8rem;
                padding: 0.4rem 1rem;
                align-self: flex-start;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                padding: 1rem;
            }

            .fg {
                min-width: 100%;
            }

            .filter-actions {
                justify-content: flex-end;
                margin-top: 0.25rem;
            }

            .btn {
                height: 38px;
                padding: 0 1rem;
                font-size: 0.8rem;
            }

            table {
                font-size: 0.8rem;
                min-width: 600px;
            }

            th, td {
                padding: 0.6rem 0.75rem;
            }

            .siswa-name {
                font-size: 0.8rem;
            }

            .avatar {
                width: 30px;
                height: 30px;
                font-size: 0.7rem;
            }

            .pagination {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1rem;
            }

            .pagi-info {
                font-size: 0.75rem;
            }

            .pagi-links a,
            .pagi-links span {
                min-width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .summary-row {
                gap: 0.5rem;
            }

            .chip {
                font-size: 0.7rem;
                padding: 0.3rem 0.8rem;
            }

            .badge-jenis {
                font-size: 0.7rem;
                padding: 0.15rem 0.6rem;
            }
        }

        @media (max-width: 480px) {
            .wrap {
                padding: 0.75rem;
            }

            .btn-back {
                padding: 0.4rem 1rem;
                font-size: 0.75rem;
            }

            .btn-back i {
                font-size: 1rem;
            }

            .top-nav-title {
                font-size: 0.75rem;
            }

            .page-header {
                padding: 1.25rem 1rem;
            }

            .page-title {
                font-size: 1.1rem;
            }

            .page-sub {
                font-size: 0.8rem;
            }

            .date-badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.8rem;
            }

            .date-badge i {
                font-size: 0.9rem;
            }

            .filter-bar {
                padding: 0.75rem;
                gap: 0.75rem;
            }

            .fg label {
                font-size: 0.65rem;
            }

            .fg select,
            .fg input[type="date"] {
                height: 36px;
                font-size: 0.8rem;
                padding: 0 0.6rem;
            }

            .btn {
                height: 34px;
                padding: 0 0.75rem;
                font-size: 0.75rem;
            }

            table {
                font-size: 0.75rem;
                min-width: 500px;
            }

            th {
                font-size: 0.6rem;
                padding: 0.5rem 0.6rem;
            }

            td {
                padding: 0.5rem 0.6rem;
            }

            .td-no {
                font-size: 0.65rem;
                width: 2rem;
            }

            .siswa-cell {
                gap: 0.5rem;
            }

            .avatar {
                width: 26px;
                height: 26px;
                font-size: 0.6rem;
            }

            .siswa-name {
                font-size: 0.75rem;
            }

            .siswa-nis {
                font-size: 0.6rem;
            }

            .badge-jenis {
                font-size: 0.65rem;
                padding: 0.1rem 0.5rem;
            }

            .badge-status {
                font-size: 0.6rem;
                padding: 0.15rem 0.6rem;
            }

            .tgl-main {
                font-size: 0.75rem;
            }

            .tgl-range {
                font-size: 0.6rem;
            }

            .dur-pill {
                font-size: 0.6rem;
                padding: 0.05rem 0.4rem;
            }

            .ket-text {
                font-size: 0.7rem;
                max-width: 120px;
            }

            .lamp-link {
                font-size: 0.65rem;
                padding: 0.1rem 0.4rem;
            }

            .lamp-link i {
                font-size: 0.7rem;
            }

            .lamp-none {
                font-size: 0.65rem;
            }

            .empty-state {
                padding: 2.5rem 1rem;
            }

            .empty-icon {
                width: 48px;
                height: 48px;
            }

            .empty-icon i {
                font-size: 20px;
            }

            .empty-state h3 {
                font-size: 0.9rem;
            }

            .empty-state p {
                font-size: 0.75rem;
            }

            .pagination {
                padding: 0.5rem 0.75rem;
            }

            .pagi-info {
                font-size: 0.65rem;
            }

            .pagi-links a,
            .pagi-links span {
                min-width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }

            .summary-row {
                gap: 0.4rem;
            }

            .chip {
                font-size: 0.65rem;
                padding: 0.2rem 0.6rem;
            }

            .chip i {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 380px) {
            .page-header {
                padding: 1rem 0.75rem;
            }

            .page-title {
                font-size: 1rem;
            }

            table {
                font-size: 0.7rem;
                min-width: 400px;
            }

            th, td {
                padding: 0.4rem 0.4rem;
            }

            .siswa-name {
                font-size: 0.7rem;
            }

            .badge-jenis {
                font-size: 0.6rem;
                padding: 0.05rem 0.4rem;
            }
        }
    </style>
</head>
<body>

<div class="wrap">

    <!-- ===== TOP NAVIGATION ===== -->
    <div class="top-nav">
        <a href="{{ route('guru.detailkelas', $isikelas->id) }}" class="btn-back">
            <i class='bx bx-arrow-back'></i>
            Kembali
        </a>
        <div class="top-nav-title">
            <i class='bx bxs-dashboard' style="margin-right: 0.3rem;"></i>
            Izin Siswa <span>{{ $isikelas->nam ?? '' }}</span>
        </div>
        @if($isWaliKelas)
            <span class="top-nav-badge" style="background:var(--c-ok-bg);color:var(--c-ok);border-color:var(--c-ok)">
                <i class='bx bxs-badge-check'></i>
                Wali Kelas
            </span>
        @endif
        <span class="top-nav-badge">
            <i class='bx bx-calendar'></i>
            Hari Ini
        </span>
    </div>

    <!-- ===== PAGE HEADER ===== -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <span class="page-eyebrow">
                    <i class='bx bxs-school'></i>
                    {{ $isikelas->nam ?? 'Kelas' }}
                </span>
                <h1 class="page-title">
                    Siswa Izin <span>Hari Ini</span>
                </h1>
                <p class="page-sub">
                    Daftar siswa yang sedang dalam periode izin pada tanggal yang dipilih
                </p>
            </div>
            <div class="date-badge">
                <i class='bx bx-calendar-check'></i>
                {{ \Carbon\Carbon::parse($activeTgl)->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>

    <!-- ===== SUMMARY CHIPS ===== -->
    <div class="summary-row">
        <span class="chip brand">
            <i class='bx bx-user-check'></i>
            {{ number_format($izinList->total()) }} siswa izin
        </span>
        @if($izinList->total() > 0)
        <span class="chip">
            <i class='bx bx-file'></i>
            Halaman {{ $izinList->currentPage() }} dari {{ $izinList->lastPage() }}
        </span>
        @endif
    </div>

    <!-- ===== FILTER BAR ===== -->
    <form method="GET" action="{{ route('guru.izin.by_kelas', $isikelas->id) }}" class="filter-bar">

        <div class="fg">
            <label><i class='bx bx-calendar'></i> Tanggal</label>
            <input type="date" name="tgl" value="{{ $activeTgl }}">
        </div>

        <div class="fg">
            <label><i class='bx bx-filter'></i> Jenis Izin</label>
            <select name="jen">
                <option value="">Semua Jenis</option>
                @foreach($jenisList as $j)
                    <option value="{{ $j->id }}" @selected(request('jen') == $j->id)>
                        {{ $j->title ?: $j->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-search-alt'></i>
                Tampilkan
            </button>
            @if(request()->hasAny(['jen','tgl']))
                <a href="{{ route('guru.izin.by_kelas', $isikelas->id) }}" class="btn btn-ghost">
                    <i class='bx bx-reset'></i>
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- ===== TABLE CARD ===== -->
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:3rem; text-align:center">#</th>
                        <th>Siswa</th>
                        <th>Jenis Izin</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                        @if($isWaliKelas)
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @forelse($izinList as $i => $izin)
                    @php
                        $namaFull = trim($izin->siswa->namlen ?? ($izin->siswa->nampan . ' ' . ($izin->siswa->namnam ?? ''))) ?: '—';
                        $inisial  = strtoupper(mb_substr($namaFull, 0, 1));

                        $mulai = $izin->tgl_mulai ? \Carbon\Carbon::parse($izin->tgl_mulai) : null;
                        $akhir = $izin->tgl_akhir ? \Carbon\Carbon::parse($izin->tgl_akhir) : null;

                        $durHari = ($mulai && $akhir)
                            ? $mulai->diffInDays($akhir) + 1
                            : 1;

                        $status = $izin->sta ?? \App\Enums\IzinStatus::PENDING; // fallback aman
                        $isPending = $status->value === \App\Enums\IzinStatus::PENDING->value;
                    @endphp
                    <tr>
                        <td class="td-no">{{ $izinList->firstItem() + $i }}</td>

                        <td>
                            @if($izin->siswa)
                                <div class="siswa-cell">
                                    <div class="avatar">{{ $inisial }}</div>
                                    <div>
                                        <span class="siswa-name">{{ $namaFull }}</span>
                                        <span class="siswa-nis">{{ $izin->siswa->nis ?? '—' }}</span>
                                    </div>
                                </div>
                            @else
                                <span style="color:var(--gray-400);font-style:italic;font-size:0.75rem">Siswa dihapus</span>
                            @endif
                        </td>

                        <td>
                            @if($izin->jenis)
                                <span class="badge-jenis">
                                    {{ $izin->jenis->title ?: $izin->jenis->name }}
                                </span>
                            @else
                                <span style="color:var(--gray-400)">—</span>
                            @endif
                        </td>

                        <td>
                            @if($mulai)
                                <div class="tgl-main">{{ $mulai->translatedFormat('d M Y') }}</div>
                                @if($akhir && $akhir->ne($mulai))
                                    <div class="tgl-range">
                                        <i class='bx bx-right-arrow-alt'></i>
                                        {{ $akhir->translatedFormat('d M Y') }}
                                    </div>
                                @endif
                                <span class="{{ $durHari === 1 ? 'dur-pill dur-1' : 'dur-pill dur-gt' }}">
                                    <i class='bx bx-time-five'></i>
                                    {{ $durHari }} hari
                                </span>
                            @else
                                <span style="color:var(--gray-400)">—</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge-status badge-status-{{ strtolower($status->name) }}">
                                {{ $status->icon() }} {{ $status->label() }}
                            </span>
                            @if($status->value === \App\Enums\IzinStatus::REJECTED->value && $izin->alasan_tolak)
                                <div class="alasan-tolak" title="{{ $izin->alasan_tolak }}">
                                    {{ \Illuminate\Support\Str::limit($izin->alasan_tolak, 40) }}
                                </div>
                            @endif
                        </td>

                        <td>
                            @if($izin->ket)
                                <span class="ket-text" title="{{ $izin->ket }}">
                                    {{ $izin->ket }}
                                </span>
                            @else
                                <span style="color:var(--gray-400);font-style:italic;font-size:0.75rem">Tidak ada keterangan</span>
                            @endif
                        </td>

                        <td>
                            @if($izin->documents->isNotEmpty())
                                <div style="display:flex;flex-direction:column;gap:0.35rem">
                                    @foreach($izin->documents as $doc)
                                        <a href="{{ $doc->url }}" target="_blank" rel="noopener" class="lamp-link">
                                            <i class='bx bx-file-blank'></i>
                                            {{ \Illuminate\Support\Str::limit($doc->name, 20, '…') }}
                                            <span class="lamp-size">{{ $doc->image_size }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @elseif($izin->dok)
                                <a href="{{ $izin->dok }}" target="_blank" class="lamp-link">
                                    <i class='bx bx-link-external'></i>
                                    Lihat Dokumen
                                </a>
                            @else
                                <span class="lamp-none">Tidak ada</span>
                            @endif
                        </td>

                        @if($isWaliKelas)
                        <td>
                            @if($isPending)
                                <div class="aksi-cell">
                                    <form method="POST" action="{{ route('guru.izin.approve', [$isikelas->id, $izin->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class='bx bx-check'></i> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-ghost btn-sm"
                                        onclick="document.getElementById('modal-tolak-{{ $izin->id }}').showModal()">
                                        <i class='bx bx-x'></i> Tolak
                                    </button>
                                </div>

                                <dialog id="modal-tolak-{{ $izin->id }}" class="modal-tolak">
                                    <form method="POST" action="{{ route('guru.izin.reject', [$isikelas->id, $izin->id]) }}">
                                        @csrf
                                        <div class="modal-title">Tolak Izin {{ $namaFull }}</div>
                                        <textarea name="alasan_tolak" class="modal-textarea" placeholder="Alasan penolakan (opsional)"></textarea>
                                        <div class="modal-actions">
                                            <button type="button" class="btn btn-ghost btn-sm"
                                                onclick="document.getElementById('modal-tolak-{{ $izin->id }}').close()">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Tolak Izin
                                            </button>
                                        </div>
                                    </form>
                                </dialog>
                            @else
                                <span class="diproses-info">
                                    {{ $status->label() }}
                                    @if($izin->approved_at)
                                        · {{ $izin->approved_at->translatedFormat('d M Y H:i') }}
                                    @endif
                                </span>
                            @endif
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isWaliKelas ? 8 : 7 }}" style="padding:0;border:none">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class='bx bx-calendar-x'></i>
                                </div>
                                <h3>Tidak ada siswa izin</h3>
                                <p>
                                    Pada tanggal
                                    <strong>{{ \Carbon\Carbon::parse($activeTgl)->translatedFormat('d F Y') }}</strong>
                                    tidak ada siswa yang sedang izin di kelas ini.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($izinList->hasPages())
        <div class="pagination">
            <span class="pagi-info">
                Menampilkan
                <strong>{{ $izinList->firstItem() }}</strong>–<strong>{{ $izinList->lastItem() }}</strong>
                dari <strong>{{ number_format($izinList->total()) }}</strong> data
            </span>

            <div class="pagi-links">
                {{-- Prev --}}
                @if($izinList->onFirstPage())
                    <span class="disabled"><i class='bx bx-chevron-left'></i></span>
                @else
                    <a href="{{ $izinList->previousPageUrl() }}" aria-label="Sebelumnya">
                        <i class='bx bx-chevron-left'></i>
                    </a>
                @endif

                @php
                    $cur   = $izinList->currentPage();
                    $last  = $izinList->lastPage();
                    $start = max(1, $cur - 2);
                    $end   = min($last, $cur + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $izinList->url(1) }}">1</a>
                    @if($start > 2)<span class="disabled" aria-hidden="true">…</span>@endif
                @endif

                @for($p = $start; $p <= $end; $p++)
                    @if($p === $cur)
                        <span class="active" aria-current="page">{{ $p }}</span>
                    @else
                        <a href="{{ $izinList->url($p) }}">{{ $p }}</a>
                    @endif
                @endfor

                @if($end < $last)
                    @if($end < $last - 1)<span class="disabled" aria-hidden="true">…</span>@endif
                    <a href="{{ $izinList->url($last) }}">{{ $last }}</a>
                @endif

                {{-- Next --}}
                @if($izinList->hasMorePages())
                    <a href="{{ $izinList->nextPageUrl() }}" aria-label="Berikutnya">
                        <i class='bx bx-chevron-right'></i>
                    </a>
                @else
                    <span class="disabled"><i class='bx bx-chevron-right'></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</body>
</html>