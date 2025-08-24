<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class TransferNotAllowedException extends Exception
{
    public function render($request): Response
    {
        return response([
            'message' => 'Transfer not allowed'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
