<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 3;
    private const DECAY_SECONDS = 300; 
   
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('guru')->check()) {
            return redirect()->route('guru.dashboard');
        }

        return view('auth.login');
    }


    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '
                        . $this->formatWaktu($seconds) . '.',
                ]);
        }

        if (Auth::guard('guru')->attempt($credentials, false)) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            $akun = Auth::guard('guru')->user();

            $nama = optional($akun->guru)->Nam ?? $akun->username;

            return redirect()
                ->intended(route('guru.dashboard'))
                ->with('success', 'Selamat datang, ' . $nama . '!');
        }

        RateLimiter::hit($throttleKey, self::DECAY_SECONDS);

        $sisaPercobaan = max(0, self::MAX_ATTEMPTS - RateLimiter::attempts($throttleKey));

        $pesan = 'Username atau password salah.';
        if ($sisaPercobaan > 0) {
            $pesan .= " Sisa percobaan: {$sisaPercobaan}x.";
        } else {
            $pesan = 'Terlalu banyak percobaan login. Silakan coba lagi dalam '
                . $this->formatWaktu(self::DECAY_SECONDS) . '.';
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => $pesan,
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('guru')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guru.login')->with('info', 'Anda telah berhasil logout.');
    }

    private function throttleKey(Request $request): string
    {
        $username = strtolower((string) $request->input('username'));

        return 'login-guru:' . $username . '|' . $request->ip();
    }

    private function formatWaktu(int $seconds): string
    {
        $menit = intdiv($seconds, 60);
        $detik = $seconds % 60;

        if ($menit > 0 && $detik > 0) {
            return "{$menit} menit {$detik} detik";
        }
        if ($menit > 0) {
            return "{$menit} menit";
        }
        return "{$detik} detik";
    }
}