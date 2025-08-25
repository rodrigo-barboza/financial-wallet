<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\OperationTypes;
use App\Events\TransactionCompleted;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class RevertTransferAction
{
    public function handle(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction): void {
            $sender = User::query()->lockForUpdate()->findOrFail($transaction->sender_id);
            $receiver = User::query()->lockForUpdate()->findOrFail($transaction->receiver_id);

            $sender->deposit($transaction->amount);
            $receiver->deposit(-$transaction->amount);

            $transaction->delete();
        });
    }
}
