<?php

namespace App\Exceptions;

use App\Core\Controller\Traits\Error;
use App\Core\Controller\Traits\LaravelResource;
use App\Core\Controller\Traits\LaravelResponse;
use App\Core\Controller\Traits\Meta;
use App\Core\Controller\Traits\Response;
use App\Http\Resources\Responses\ExceptionResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    use Error, LaravelResponse, LaravelResource, Meta, Response;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorUnauthorized($exception->getMessage());
    }

    protected function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        return $this->setErrors($exception->validator->errors()->all())
            ->setStatusCode($exception->status)->respondWithItem($exception, ExceptionResource::class);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        return $this
            ->setStatusCode(
                $this->isHttpException($e) ? $e->getStatusCode() : 500)
            ->setHeaders(
                $this->isHttpException($e) ? $e->getHeaders() : [])
            ->setErrors((array)$e->getMessage())
            ->respondWithItem($e, ExceptionResource::class);
    }
}
