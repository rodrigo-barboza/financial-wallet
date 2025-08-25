<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Actions\TransferAction;
use App\Enums\OperationTypes;
use App\Events\TransactionCompleted;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TransferActionTest extends TestCase
{
    public function test_cannot_transfer_with_invalid_transaction_type(): void
    {
        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        /** @var \App\Models\User */
        $receiver = User::factory()->create(['balance' => 0]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid transaction type');

        app(TransferAction::class)->handle($sender->id, [
            'type' => 'invalid',
            'account' => Str::replace('-', '', $receiver->account),
            'agency' => $receiver->agency,
            'amount' => 500.0,
        ]);

        Event::assertNotDispatched(TransactionCompleted::class);

        $this->assertDatabaseMissing(Transaction::class, [
            'type' => OperationTypes::TRANSFER->value,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => 50000,
        ]);
    }
}
