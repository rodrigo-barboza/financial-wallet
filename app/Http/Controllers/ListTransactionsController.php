<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ListTransactionsController
{
    public function __invoke(): AnonymousResourceCollection
    {
        return TransactionResource::collection(
            Transaction::where('sender_id', request()->user()->id)
                ->with('receiver')
                ->orderBy('created_at', 'desc')
                ->get(),
        );
    }
}
