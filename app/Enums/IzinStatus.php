<?php

namespace App\Enums;

enum IzinStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;

    case EXITED   = -2; // keluar — tetap pakai nilai lama dari DB


    /**
     * Label untuk tampilan (UI-friendly).
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::EXITED   => 'Keluar',
        };
    }

    /**
     * Warna untuk badge/indicator di UI.
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'yellow',
            self::APPROVED => 'green',
            self::REJECTED => 'red',
            self::EXITED   => 'gray',
        };
    }

    /**
     * Icon untuk representasi visual.
     */
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => '⏳',
            self::APPROVED => '✅',
            self::REJECTED => '❌',
            self::EXITED   => '🚪',
        };
    }

    /**
     * Create enum instance from string value.
     * Handles both integer strings and case names.
     */
    public static function fromString(string $value): ?self
    {
        if (empty($value)) {
            return null;
        }

        // Try parsing as integer value
        if (is_numeric($value)) {
            try {
                return self::from((int) $value);
            } catch (\ValueError) {
                return null;
            }
        }

        // Try matching case name (case-insensitive)
        foreach (self::cases() as $case) {
            if (strtoupper($case->name) === strtoupper($value)) {
                return $case;
            }
        }

        return null;
    }

       public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING  => 'badge--pending',
            self::APPROVED => 'badge--approved',
            self::REJECTED => 'badge--rejected',
            self::EXITED   => 'badge--exited',
        };
    }

}
