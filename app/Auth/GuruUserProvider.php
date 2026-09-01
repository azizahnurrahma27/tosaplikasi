<?php

namespace App\Auth;

use App\Models\Takunguru;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class GuruUserProvider implements UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        return Takunguru::with('guru')->find($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     */
    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        // Tidak menggunakan remember me token untuk saat ini
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     */
    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // Tidak menggunakan remember me token
    }

    /**
     * Retrieve a user by the given credentials.
     */
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (empty($credentials['username'])) {
            return null;
        }

        return Takunguru::with('guru')
            ->where('username', $credentials['username'])
            ->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * Password seharusnya sudah di-hash (bcrypt) via Hash::make() saat
     * dibuat/diupdate lewat AkunGuruController. Namun beberapa akun lama
     * masih menyimpan password plain text, jadi kita fallback ke
     * perbandingan plain text khusus untuk akun-akun tersebut.
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $hashedPassword = $user->getAuthPassword();

        // Kasus normal: password sudah bcrypt.
        if (Hash::check($credentials['password'], $hashedPassword)) {
            return true;
        }

        // Fallback untuk akun lama yang password-nya masih plain text
        // (belum pernah diupdate lewat form akun guru).
        if (! Hash::isHashed($hashedPassword) && $hashedPassword === $credentials['password']) {
            return true;
        }

        return false;
    }

    /**
     * Rehash the user's password if required and supported.
     *
     * Dipanggil otomatis oleh Laravel setelah login berhasil. Kita pakai
     * ini untuk "migrasi diam-diam": akun lama yang masih plain text
     * langsung diubah ke bcrypt begitu berhasil login sekali.
     */
    public function rehashPasswordIfRequired(
        Authenticatable $user,
        array $credentials,
        bool $force = false
    ): void {
        $hashedPassword = $user->getAuthPassword();

        if (! Hash::isHashed($hashedPassword) || $force) {
            if ($user instanceof Model) {
                $user->forceFill([
                    $user->getAuthPasswordName() => Hash::make($credentials['password']),
                ])->save();
            }
        } elseif (Hash::needsRehash($hashedPassword)) {
            if ($user instanceof Model) {
                $user->forceFill([
                    $user->getAuthPasswordName() => Hash::make($credentials['password']),
                ])->save();
            }
        }
    }
}