<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class IncorrectReceiveAccountException extends Exception
{
    public function render($request): Response
    {
        return response([
            'message' => 'Incorrect receive account'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
