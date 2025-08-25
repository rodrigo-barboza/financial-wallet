<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\DepositAction;
use App\Http\Requests\StoreDepositRequest;
use Illuminate\Http\Response;

final class DepositController
{
    public function __invoke(StoreDepositRequest $request, DepositAction $action): Response
    {
        $action->handle($request->user()->id, $request->validated());
        // $request->user()->deposit($request->amount);

        return response(['message' => 'Deposito realizado com sucesso'], Response::HTTP_CREATED);
    }
}
