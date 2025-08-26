<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\TransactionTypes;
use App\Strategies\TED;
use ValueError;

final class TransferAction
{
    public function handle(int $senderId, array $transfer): void
    {
        $transaction = match(TransactionTypes::from($transfer['type'])) {
            TransactionTypes::TED => app(TED::class),
            default => null,
        };

        if (! $transaction) {
            throw new ValueError('Invalid transaction type');
        }

        $transaction->handle($senderId, $transfer);
    }
}
