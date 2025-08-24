<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InsufficientBalanceException extends Exception
{
    public function render($request): Response
    {
        return response([
            'message' => 'Insufficient balance'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
