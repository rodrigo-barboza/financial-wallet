<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\RevertTransferAction;
use App\Models\Transaction;
use Illuminate\Http\Response;

final class RevertTransactionController
{
    public function __invoke(Transaction $transaction, RevertTransferAction $action): Response
    {
        $action->handle($transaction);

        return response(['message' => 'Transferência revertida com sucesso'], Response::HTTP_CREATED);
    }
}