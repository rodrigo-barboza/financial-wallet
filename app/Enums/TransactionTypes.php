<?php

namespace App\Enums;

enum TransactionTypes: string
{
    case TED = 'ted';

    public function label(): string
    {
        return match ($this) {
            self::TED => 'TED',
        };
    }
}
