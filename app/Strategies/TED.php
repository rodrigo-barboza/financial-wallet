<?php

namespace App\Strategies;

use App\Enums\OperationTypes;
use App\Events\TransactionCompleted;
use App\Exceptions\IncorrectReceiveAccountException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\TransferNotAllowedException;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class TED implements TransactionStrategy
{
    public function handle(int $senderId, array $transfer): void
    {
        DB::transaction(function () use ($senderId, $transfer): void {
            ['account' => $account, 'agency' => $agency, 'amount' => $amount] = $transfer;

            $sender = User::query()->lockForUpdate()->findOrFail($senderId);

            throw_if(! $sender->haveEnoughBalance($amount), InsufficientBalanceException::class);

            $receiver = User::query()
                ->whereAccount($account)
                ->whereAgency($agency)
                ->lockForUpdate()
                ->first();

            throw_if(! $receiver, IncorrectReceiveAccountException::class);

            throw_if(! $sender->canTransferTo($receiver), TransferNotAllowedException::class);

            $sender->deposit(-$amount);
            $receiver->deposit($amount);

            $transaction = Transaction::create([
                'type' => OperationTypes::TRANSFER,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
            ]);

            TransactionCompleted::dispatch($transaction);
        });
    }
}
