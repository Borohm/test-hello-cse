<?php

namespace App\Enums;

enum ProductStatus
{
    case ACTIVE;
    case DRAFT;
    case DISABLED;

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'En ligne',
            self::DRAFT => 'Brouillon',
            self::DISABLED => 'Désactivée',
        };
    }
}
