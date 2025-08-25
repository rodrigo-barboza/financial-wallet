<?php

declare(strict_types=1);

namespace Tests\Feature\Strategies;

use App\Actions\TransferAction;
use App\Enums\OperationTypes;
use App\Enums\TransactionTypes;
use App\Events\TransactionCompleted;
use App\Exceptions\IncorrectReceiveAccountException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\TransferNotAllowedException;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Support\Str;

class TEDTest extends TestCase
{
    public function test_can_successfully_perform_a_transfer(): void
    {
        Event::fake();

        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        /** @var \App\Models\User */
        $receiver = User::factory()->create(['balance' => 0]);

        app(TransferAction::class)->handle($sender->id, [
            'type' => TransactionTypes::TED->value,
            'account' => Str::replace('-', '', $receiver->account),
            'agency' => $receiver->agency,
            'amount' => 500.0,
        ]);

        Event::assertDispatched(TransactionCompleted::class);

        $this->assertDatabaseHas(User::class, [
            'id' => $sender->id,
            'balance' => 50000,
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $receiver->id,
            'balance' => 50000,
        ]);

        $this->assertDatabaseHas(Transaction::class, [
            'type' => OperationTypes::TRANSFER->value,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => 50000,
        ]);
    }

    public function test_cannot_perform_a_transfer_with_insufficient_balance(): void
    {
        Event::fake();

        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 100]);

        /** @var \App\Models\User */
        $receiver = User::factory()->create(['balance' => 0]);

        $this->expectException(InsufficientBalanceException::class);

        app(TransferAction::class)->handle($sender->id, [
            'type' => TransactionTypes::TED->value,
            'account' => Str::replace('-', '', $receiver->account),
            'agency' => $receiver->agency,
            'amount' => 500.0,
        ]);

        Event::assertNotDispatched(TransactionCompleted::class);

        $this->assertDatabaseHas(User::class, [
            'id' => $sender->id,
            'balance' => 100,
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $receiver->id,
            'balance' => 0,
        ]);

        $this->assertDatabaseMissing(Transaction::class, [
            'type' => TransactionTypes::TED->value,
            'type' => OperationTypes::TRANSFER->value,
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'amount' => 50000,
        ]);
    }

    public function test_cannot_perform_a_transfer_to_itself(): void
    {
        Event::fake();

        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        $this->expectException(TransferNotAllowedException::class);

        app(TransferAction::class)->handle($sender->id, [
            'type' => TransactionTypes::TED->value,
            'account' => Str::replace('-', '', $sender->account),
            'agency' => $sender->agency,
            'amount' => 500.0,
        ]);

        Event::assertNotDispatched(TransactionCompleted::class);

        $this->assertDatabaseHas(User::class, [
            'id' => $sender->id,
            'balance' => 1000,
        ]);

        $this->assertDatabaseMissing(Transaction::class, [
            'sender_id' => $sender->id,
            'receiver_id' => $sender->id,
            'amount' => 50000,
        ]);
    }

    public function test_cannot_perform_a_transfer_to_an_invalid_account(): void
    {
        Event::fake();

        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        $this->expectException(IncorrectReceiveAccountException::class);

        app(TransferAction::class)->handle($sender->id, [
            'type' => TransactionTypes::TED->value,
            'account' => 0000000,
            'agency' => 0,
            'amount' => 500.0,
        ]);

        Event::assertNotDispatched(TransactionCompleted::class);

        $this->assertDatabaseHas(User::class, [
            'id' => $sender->id,
            'balance' => 1000,
        ]);

        $this->assertDatabaseMissing(Transaction::class, [
            'type' => OperationTypes::TRANSFER->value,
            'sender_id' => $sender->id,
            'receiver_id' => $sender->id,
            'amount' => 50000,
        ]);
    }
}
