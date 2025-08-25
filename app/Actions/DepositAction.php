<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\OperationTypes;
use App\Events\TransactionCompleted;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class DepositAction
{
    public function handle(int $userId, array $deposit): void
    {
        DB::transaction(function () use ($userId, $deposit): void {
            $user = User::query()->lockForUpdate()->findOrFail($userId);

            $user->deposit($deposit['amount']);

            $transaction = Transaction::create([
                'type' => OperationTypes::DEPOSIT,
                'amount' => $deposit['amount'],
                'sender_id' => $userId,
                'receiver_id' => $userId,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ]);

            TransactionCompleted::dispatch($transaction);
        });
    }
}
