<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Actions\DepositAction;
use App\Enums\TransactionTypes;
use App\Events\TransactionCompleted;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DepositActionTest extends TestCase
{
    public function test_can_successfully_perform_a_deposit(): void
    {
        Event::fake();

        /** @var \App\Models\User */
        $user = User::factory()->create(['balance' => 1000]);

        app(DepositAction::class)->handle($user->id, ['amount' => 500.0]);

        Event::assertDispatched(TransactionCompleted::class);

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'balance' => 150000,
        ]);

        $this->assertDatabaseHas(Transaction::class, [
            'type' => TransactionTypes::DEPOSIT->value,
            'sender_id' => $user->id,
            'receiver_id' => $user->id,
            'amount' => 50000,
        ]);
    }
}
