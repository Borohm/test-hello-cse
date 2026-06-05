<?php

namespace App\Enums;

enum CategoryStatus: string
{
    case ACTIVE = 'active';
    case DISABLED = 'disabled';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'En ligne',
            self::DISABLED => 'Désactivée',
            self::ARCHIVED => 'Archivée',
        };
    }
}
