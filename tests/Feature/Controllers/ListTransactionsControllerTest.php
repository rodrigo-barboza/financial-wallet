<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\TestCase;

class ListTransactionsControllerTest extends TestCase
{
    public function test_can_list_transactions(): void
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('transactions'))
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'amount',
                        'receiver',
                        'date',
                    ],
                ]
            ])
            ->assertOk();
    }
}
