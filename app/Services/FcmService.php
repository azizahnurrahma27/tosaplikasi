<?php

namespace App\Services;

use App\Models\Auth\MobileAccessToken;
use App\Models\Tkelsis;
use App\Models\Tsiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    private const TUGAS_FOR_KELAS = 'kelas';
    private const TUGAS_FOR_SISWA = 'siswa';

    private const OAUTH_SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';
    private const OAUTH_TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const ACCESS_TOKEN_CACHE_KEY = 'fcm_oauth_access_token';

    public function sendTaskNotification(array $data, array $payload): void
    {
        try {
            $tokens = $this->resolveRecipientTokens($data);

            if (empty($tokens)) {
                Log::info('FCM: tidak ada token penerima yang valid untuk notifikasi tugas.', [
                    'idtugas' => $payload['task_id'] ?? null,
                    'tugasFor' => $data['tugasFor'] ?? null,
                ]);
                return;
            }

            $title = 'Tugas Baru';
            $body  = sprintf('Ada tugas baru: %s dari %s', $payload['judul'], $payload['mapel']);

            foreach ($tokens as $tokenRow) {
                $this->sendToToken($tokenRow, $title, $body, $payload);
            }
        } catch (\Throwable $e) {
            Log::error('FCM: gagal memproses pengiriman notifikasi tugas.', [
                'message' => $e->getMessage(),
                'task_id' => $payload['task_id'] ?? null,
            ]);
        }
    }

    private function resolveRecipientTokens(array $data): \Illuminate\Support\Collection
    {
        $nisList = $data['tugasFor'] === self::TUGAS_FOR_SISWA
            ? $this->resolveNisnsForStudents($data['siswa_ids'])
            : $this->resolveNisnsForClass($data['idkelas']);

        if (empty($nisList)) {
            return collect();
        }

        return MobileAccessToken::query()
            ->whereIn('nouid', $nisList)
            ->whereNotNull('fcm_token')
            ->where('fcm_token', '!=', '')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', Carbon::now());
            })
            ->get();
    }

    private function resolveNisnsForStudents(array $studentIds): array
    {
        return Tsiswa::query()
            ->whereIn('id', $studentIds)
            ->whereNotNull('nis')
            ->pluck('nis')
            ->unique()
            ->values()
            ->all();
    }

    private function resolveNisnsForClass(int $idKelas): array
    {
        $studentIds = Tkelsis::query()
            ->where('idkel', $idKelas)
            ->pluck('ids')
            ->unique()
            ->values()
            ->all();

        if (empty($studentIds)) {
            return [];
        }

        return $this->resolveNisnsForStudents($studentIds);
    }

    private function sendToToken(MobileAccessToken $tokenRow, string $title, string $body, array $payload): void
    {
        $fcmToken = $tokenRow->fcm_token;

        try {
            $accessToken = $this->getAccessToken();
            $projectId = config('services.fcm.project_id');

            $response = Http::withToken($accessToken)
                ->timeout(10)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $fcmToken,
                        'notification' => [
                            'title' => $title,
                            'body'  => $body,
                        ],
                        'data' => array_map('strval', $payload),
                    ],
                ]);

            if ($response->successful()) {
                Log::info('FCM: notifikasi tugas terkirim.', [
                    'nouid'     => $tokenRow->nouid,
                    'token_id'  => $tokenRow->id,
                    'task_id'   => $payload['task_id'] ?? null,
                ]);
                return;
            }

            Log::warning('FCM: pengiriman notifikasi gagal (response error).', [
                'nouid'    => $tokenRow->nouid,
                'token_id' => $tokenRow->id,
                'task_id'  => $payload['task_id'] ?? null,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('FCM: pengiriman notifikasi gagal (exception).', [
                'nouid'    => $tokenRow->nouid,
                'token_id' => $tokenRow->id,
                'task_id'  => $payload['task_id'] ?? null,
                'message'  => $e->getMessage(),
            ]);
        }
    }

    private function getAccessToken(): string
    {
        return Cache::remember(self::ACCESS_TOKEN_CACHE_KEY, now()->addMinutes(55), function () {
            $credentialsPath = config('services.fcm.credentials_path');

            if (!is_string($credentialsPath) || !file_exists($credentialsPath)) {
                throw new \RuntimeException("FCM: file kredensial service-account tidak ditemukan di [{$credentialsPath}].");
            }

            $credentials = json_decode(file_get_contents($credentialsPath), true, flags: JSON_THROW_ON_ERROR);

            $jwt = $this->buildSignedJwt($credentials);

            $response = Http::asForm()
                ->timeout(10)
                ->post(self::OAUTH_TOKEN_URL, [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion'  => $jwt,
                ]);

            if (!$response->successful()) {
                throw new \RuntimeException('FCM: gagal menukar JWT untuk access token. Response: ' . $response->body());
            }

            $accessToken = $response->json('access_token');

            if (!is_string($accessToken) || $accessToken === '') {
                throw new \RuntimeException('FCM: access token tidak ditemukan pada response OAuth.');
            }

            return $accessToken;
        });
    }

    private function buildSignedJwt(array $credentials): string
    {
        $now = time();

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $claims = [
            'iss'   => $credentials['client_email'],
            'scope' => self::OAUTH_SCOPE,
            'aud'   => self::OAUTH_TOKEN_URL,
            'iat'   => $now,
            'exp'   => $now + 3600,
        ];

        $segments = [
            $this->base64UrlEncode(json_encode($header, JSON_THROW_ON_ERROR)),
            $this->base64UrlEncode(json_encode($claims, JSON_THROW_ON_ERROR)),
        ];

        $signingInput = implode('.', $segments);

        $privateKey = openssl_pkey_get_private($credentials['private_key']);

        if ($privateKey === false) {
            throw new \RuntimeException('FCM: private_key pada service-account JSON tidak valid.');
        }

        $signature = '';
        $signed = openssl_sign($signingInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$signed) {
            throw new \RuntimeException('FCM: gagal menandatangani JWT.');
        }

        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}