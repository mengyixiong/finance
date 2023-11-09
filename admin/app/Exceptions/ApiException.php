<?php

namespace App\Exceptions;

use App\Constant\RetConstant;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ApiException extends Exception
{

    public function __construct($code = 0, $message = "", Throwable $previous = null)
    {
        $message = $message?:__R__($code ?? RetConstant::SERVER_CRASH);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return erred($this->getCode(), $this->getMessage());
    }
}
