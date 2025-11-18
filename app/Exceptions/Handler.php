<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            // dd(vars: $exception);
            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            } else {
                $statusCode = 500;
                if ($exception instanceof ModelNotFoundException) {
                    return $this->errorResponse('exceptions.not_found', 404);

                }
                if ($exception instanceof AuthenticationException) {
                    return $this->errorResponse(__('exceptions.unauthenticated'), 401);

                }
                if ($exception instanceof ValidationException) {
                    return $this->errorResponse($exception->getMessage(), 422);
                }

                if ($exception instanceof QueryException) {
                    if ($exception->getCode() == 23000) {
                        return $this->errorResponse('Duplicate entry. The title already exists.', 409);
                    }
                }

            }
            return $this->errorResponse(__('exceptions.' . $exception->getMessage()), $statusCode);

        }

        return parent::render($request, $exception);
    }
}
