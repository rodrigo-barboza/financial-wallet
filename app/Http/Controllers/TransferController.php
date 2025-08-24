<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\TransferAction;
use App\Http\Requests\StoreTransferRequest;
use Illuminate\Http\Response;

final class TransferController
{
    public function __invoke(StoreTransferRequest $request, TransferAction $action): Response
    {
        $action->handle($request->user()->id, $request->validated());

        return response(['message' => 'Transferência realizada com sucesso'], Response::HTTP_CREATED);
    }
}
