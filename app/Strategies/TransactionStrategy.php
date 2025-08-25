<?php

declare(strict_types=1);

namespace App\Strategies;

interface TransactionStrategy
{
    public function handle(int $senderId, array $transfer);
}
