<?php

namespace App\Enums;

enum OperationTypes: string
{
    case DEPOSIT = 'deposit';
    case TRANSFER = 'transfer';

    public function label(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Depósito',
            self::TRANSFER => 'Transferência',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::DEPOSIT => 'bg-green-100 text-green-800',
            self::TRANSFER => 'bg-red-100 text-red-800',
        };
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label(),
            'badge' => $this->badge(),
            'value' => $this->value,
        ];
    }
}
