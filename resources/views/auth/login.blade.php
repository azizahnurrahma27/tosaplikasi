<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru - Sistem Informasi Sekolah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* ===== CSS Variables ===== */
        :root {
            --primary-dark: #1a2a4a;
            --primary-blue: #2c5f8a;
            --primary-light: #4a8fc7;
            --primary-gradient: linear-gradient(135deg, #1a2a4a 0%, #2c5f8a 50%, #4a8fc7 100%);
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
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10);
            --shadow-xl: 0 20px 25px rgba(26, 42, 74, 0.15);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* ===== Reset & Base ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            /* HAPUS overflow: hidden biar bisa di-scroll */
        }

        /* ===== Background Pattern ===== */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0.05;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(44, 95, 138, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        /* ===== Container ===== */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            /* HAPUS height: 100vh biar bisa di-scroll */
        }

        /* ===== Logo / Brand ===== */
        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            background: var(--primary-gradient);
            border-radius: var(--radius-lg);
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 20px rgba(44, 95, 138, 0.3);
        }

        .brand-logo i {
            font-size: 36px;
            color: var(--white);
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 0.85rem;
            color: var(--gray-500);
            font-weight: 400;
        }

        /* ===== Card ===== */
        .login-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.5);
            backdrop-filter: blur(10px);
        }

        /* ===== Card Header ===== */
        .card-header {
            background: var(--primary-gradient);
            padding: 1.75rem 2rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .card-header .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .card-header .icon-wrap i {
            font-size: 28px;
            color: var(--white);
        }

        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            margin: 0;
            position: relative;
            z-index: 1;
            letter-spacing: -0.02em;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.875rem;
            margin: 0.15rem 0 0;
            position: relative;
            z-index: 1;
        }

        /* ===== Card Body ===== */
        .card-body {
            padding: 2rem 2rem 1.75rem;
        }

        /* ===== Flash Messages ===== */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            animation: slideDown 0.3s ease forwards;
        }

        .alert i {
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid #fca5a5;
        }

        .alert-info {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid #a7f3d0;
        }

        /* ===== Form ===== */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group:last-of-type {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.4rem;
            font-family: var(--font-family);
        }

        .form-label i {
            font-size: 1rem;
            color: var(--gray-400);
        }

        .form-control {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 0.9rem;
            color: var(--gray-800);
            transition: var(--transition);
            background: var(--gray-50);
            font-family: var(--font-family);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(44, 95, 138, 0.1);
        }

        .form-control.error {
            border-color: var(--danger);
            background: var(--danger-bg);
        }

        .form-control.error:focus {
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-400);
            font-size: 0.85rem;
        }

        .form-error {
            font-size: 0.75rem;
            color: var(--danger);
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .form-error i {
            font-size: 0.85rem;
        }

        /* ===== Password Toggle ===== */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.25rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--gray-600);
        }

        /* ===== Submit Button ===== */
        .btn-submit {
            width: 100%;
            padding: 0.8rem;
            background: var(--primary-gradient);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-size: 0.95rem;
            font-weight: 600;
            font-family: var(--font-family);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 95, 138, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            font-size: 1.2rem;
        }

        /* ===== Loading State Tombol ===== */
        .btn-submit .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .btn-submit:disabled::before {
            display: none;
        }

        .btn-spinner {
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255, 255, 255, 0.35);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== Card Footer ===== */
        .card-footer {
            padding: 1rem 2rem;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
            text-align: center;
        }

        .card-footer p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 0;
        }

        .card-footer .footer-brand {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* ===== Animations ===== */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .login-card {
            animation: fadeIn 0.4s ease forwards;
        }

        .brand-header {
            animation: fadeIn 0.4s ease 0.1s both;
        }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .login-container {
                max-width: 100%;
            }

            .brand-logo {
                width: 60px;
                height: 60px;
            }

            .brand-logo i {
                font-size: 28px;
            }

            .brand-title {
                font-size: 1.25rem;
            }

            .card-header {
                padding: 1.5rem 1.25rem;
            }

            .card-header h1 {
                font-size: 1.25rem;
            }

            .card-body {
                padding: 1.5rem 1.25rem;
            }

            .card-footer {
                padding: 0.75rem 1.25rem;
            }

            .form-control {
                padding: 0.6rem 0.85rem;
                font-size: 0.85rem;
            }

            .btn-submit {
                padding: 0.7rem;
                font-size: 0.85rem;
            }

            .card-header .icon-wrap {
                width: 48px;
                height: 48px;
            }

            .card-header .icon-wrap i {
                font-size: 22px;
            }
        }

        @media (max-width: 360px) {
            .card-header {
                padding: 1.25rem 1rem;
            }

            .card-body {
                padding: 1.25rem 1rem;
            }

            .card-footer {
                padding: 0.5rem 1rem;
            }

            .brand-title {
                font-size: 1.1rem;
            }

            .brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <!-- ===== BRAND HEADER ===== -->
        <div class="brand-header">
            <div class="brand-logo">
                <i class='bx bxs-school'></i>
            </div>
            <h1 class="brand-title">Sistem Informasi Sekolah</h1>
            <p class="brand-subtitle">Portal Guru</p>
        </div>

        <!-- ===== LOGIN CARD ===== -->
        <div class="login-card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="icon-wrap">
                    <i class='bx bx-user-circle'></i>
                </div>
                <h1>Selamat Datang</h1>
                <p>Masuk ke akun guru Anda</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">

                {{-- Flash Messages --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class='bx bx-x-circle'></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info">
                        <i class='bx bx-info-circle'></i>
                        <div>{{ session('info') }}</div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class='bx bx-check-circle'></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                {{-- Form Login --}}
                <form method="POST" action="{{ route('guru.login.submit') }}" novalidate id="loginForm">
                    @csrf

                    {{-- Username --}}
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class='bx bx-user'></i>
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            autocomplete="username"
                            autofocus
                            class="form-control {{ $errors->has('username') ? 'error' : '' }}"
                            placeholder="Masukkan username Anda"
                        >
                        @error('username')
                            <div class="form-error">
                                <i class='bx bx-error-circle'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class='bx bx-lock'></i>
                            Password
                        </label>
                        <div class="password-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                autocomplete="current-password"
                                class="form-control {{ $errors->has('password') ? 'error' : '' }}"
                                placeholder="Masukkan password Anda"
                            >
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                <i class='bx bx-hide'></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="form-error">
                                <i class='bx bx-error-circle'></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span class="btn-content">
                            <i class='bx bx-log-in'></i>
                            <span class="btn-text">Masuk</span>
                        </span>
                    </button>

                </form>

            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <p>
                    &copy; {{ date('Y') }}
                    <span class="footer-brand">Sistem Informasi Sekolah</span>
                    — All rights reserved
                </p>
            </div>

        </div>

    </div>

    <!-- ===== SCRIPTS ===== -->
    <script>
        (function() {
            'use strict';

            // ===== Toggle Password Visibility =====
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.className = type === 'password' ? 'bx bx-hide' : 'bx bx-show';
                    }
                });
            }

            // ===== Auto-hide alerts after 5 seconds =====
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.3s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });

            // ===== Loading State saat Submit Login =====
            const loginForm = document.getElementById('loginForm');
            const btnSubmit  = document.getElementById('btnSubmit');

            if (loginForm && btnSubmit) {
                loginForm.addEventListener('submit', function(e) {
                    // Cegah submit dobel kalau tombol sudah disabled
                    // (misal user spam klik/enter sebelum browser sempat proses disable)
                    if (btnSubmit.disabled) {
                        e.preventDefault();
                        return;
                    }

                    // Disable tombol supaya tidak bisa dipencet berkali-kali,
                    // lalu ganti isi tombol jadi spinner + teks "Memproses..."
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = `
                        <span class="btn-content">
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Memproses...</span>
                        </span>
                    `;

                    // Form tetap dibiarkan submit normal (server-side redirect).
                    // Kalau nanti ada validasi gagal & halaman reload balik ke sini,
                    // tombol otomatis kembali normal karena ini fresh page load.
                });
            }

        })();
    </script>

</body>
</html>