<?php

namespace App\Enums;

enum CategoryStatus
{
    case ACTIVE;
    case DISABLED;
    case ARCHIVED;
    
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'En ligne',
            self::DISABLED => 'Désactivée',
            self::ARCHIVED => 'Archivée',
        };
    }
}
