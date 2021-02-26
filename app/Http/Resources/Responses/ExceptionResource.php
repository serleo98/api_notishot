<?php

namespace App\Http\Resources\Responses;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $errors = [];

        if (property_exists($this->resource, 'validator')) {
            $errors = $this->resource->validator->errors()->toArray();
        }

        return [
            'error' => true,
            'errors' => $errors,
            'errorType' => 'exception',
            'httpCode' => $this->getCode(),
            'message' => $this->resource->getMessage(),
            'exception' => get_class($this->resource),
            'file' => $this->when(config('app.debug'), $this->resource->getFile()),
            'line' => $this->when(config('app.debug'), $this->resource->getLine()),
//            'trace' => $this->when(config('app.debug'), $this->resource->getTrace())
        ];
    }

    protected function getCode()
    {
        return $this->resource->status ??
            (property_exists($this->resource, 'getStatusCode') ?
                $this->resource->getStatusCode() : 500);
    }

    protected function isHttpException(\Exception $e)
    {
        return $e instanceof HttpExceptionInterface;
    }
}
