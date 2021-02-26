<?php

namespace App\Http\Resources\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'error' => true,
            'errors' => $this->getErrors(),
            'errorType' => 'error',
            'data' => null,
            'httpCode' => $this->getStatusCode(),
            'message' => $this->getMessage(),
        ];
    }
}
