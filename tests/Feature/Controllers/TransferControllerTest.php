<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Enums\TransactionTypes;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;

class TransferControllerTest extends TestCase
{
    public function test_can_transfer_successfully(): void
    {
        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        /** @var \App\Models\User */
        $receiver = User::factory()->create(['balance' => 0]);

        $this->actingAs($sender)
            ->post(route('transfer'), [
                'type' => TransactionTypes::TED->value,
                'account' => Str::replace('-', '', $receiver->account),
                'agency' => $receiver->agency,
                'amount' => 500.0,
            ])
            ->assertJson(['message' => 'Transferência realizada com sucesso'])
            ->assertCreated();

        $this->assertDatabaseHas(User::class, [
            'id' => $sender->id,
            'balance' => 50000,
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $receiver->id,
            'balance' => 50000,
        ]);
    }

    #[DataProvider('invalidTransferPayload')]
    public function test_cannot_transfer_with_invalid_payload(
        array $payload,
        array $errors
    ): void
    {
        /** @var \App\Models\User */
        $sender = User::factory()->create(['balance' => 1000]);

        User::factory()->create([
            'account' => 0000000,
            'agency' => 0000,
            'balance' => 0,
        ]);

        $this->expectException(ValidationException::class);

        $this->actingAs($sender)
            ->post(route('transfer'), $payload)
            ->assertJsonValidationErrors($errors);
    }

    public static function invalidTransferPayload(): array
    {
        return [
            'without amount' => [
                'payload' => [
                    'account' => 0000000,
                    'agency' => 0000,
                    'amount' => null,
                ],
                'errors' => ['amount'], 
            ],
            'without account' => [
                'payload' => [
                    'account' => null,
                    'agency' => 0000,
                    'amount' => 500.0,
                ],
                'errors' => ['account'], 
            ],
            'without agency' => [
                'payload' => [
                    'account' => 0000000,
                    'agency' => null,
                    'amount' => 500.0,
                ],
                'errors' => ['agency'], 
            ],
            'with invalid account' => [
                'payload' => [
                    'account' => 'invalid',
                    'agency' => 0000,
                    'amount' => 500.0,
                ],
                'errors' => ['account'], 
            ],
            'with invalid agency' => [
                'payload' => [
                    'account' => 11111111,
                    'agency' => 1111,
                    'amount' => 500.0,
                ],
                'errors' => ['agency'], 
            ],
            'with invalid amount' => [
                'payload' => [
                    'account' => 0000000,
                    'agency' => 0000,
                    'amount' => -500.0,
                ],
                'errors' => ['amount'], 
            ],
        ];
    }
}
