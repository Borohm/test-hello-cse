<?php

namespace App\Enums;

enum ProductStatus: string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case DISABLED = 'disabled';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'En ligne',
            self::DRAFT => 'Brouillon',
            self::DISABLED => 'Désactivée',
        };
    }
}
