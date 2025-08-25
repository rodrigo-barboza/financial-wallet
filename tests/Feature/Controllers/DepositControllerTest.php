<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DepositControllerTest extends TestCase
{
    public function test_can_deposit_money(): void
    {
        /** @var \App\Models\User */
        $user = User::factory()->create(['balance' => 0]);

        $this->actingAs($user)
            ->post(route('deposit'), ['amount' => 1000.0])
            ->assertJson(['message' => 'Deposito realizado com sucesso'])
            ->assertCreated();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'balance' => 100000,
        ]);
    }

    #[DataProvider('invalidDeposits')]
    public function test_cannot_deposit_negative_amount(mixed $amount, string $message): void
    {
        /** @var \App\Models\User */
        $user = User::factory()->create(['balance' => 0]);

        $this->expectException(ValidationException::class);

        $this->actingAs($user)
            ->post(route('deposit'), compact('amount'))
            ->assertFound()
            ->assertJson(compact('message'));
    }

    public static function invalidDeposits(): array
    {
        return [
            'negative_amount' => [-1000.0, 'A quantia deve ser maior ou igual a R$ 1,00.'],
            'null_amount' => [null, 'A quantia é obrigatória.'],
            'invalid_string_amount' => ['invalid', 'A quantia deve ser um número.'],
            'zero_amount' => [0.0, 'A quantia deve ser maior ou igual a R$ 1,00.'],
            'empty_string_amount' => ['', 'A quantia é obrigatória.'],
        ];
    }
}
