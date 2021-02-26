<?php

namespace App\Core\Controller\Traits;

use App\Core\Entities\CommonInternalResponse;
use App\Http\Resources\Responses\ErrorResource;
use App\Http\Resources\Responses\SuccessResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use function Psy\debug;

/**
 * Trait Response
 * @package App\Core\Controller\Traits
 */
trait Response
{
    /**
     * Count the tries to make a response
     *
     * @var int
     */
    private $tries = 0;

    /**
     * HTTP header options
     *
     * @var array
     */
    private $headers = [];

    /**
     * HTTP header status code.
     *
     * @var int
     */
    private $statusCode = 200;

    /**
     * Data wrapper for the response.
     *
     * @var string
     */
    protected $wrapper = 'data';

    /**
     * Variable to add message in debug mode
     *
     * @var string
     */
    private $debug_message = '';

    /**
     * Data for the response.
     *
     * @var mixed
     */
    private $data = null;

    /**
     * Message for the response.
     *
     * @var string
     */
    private $message = '';

    /**
     * Getter for headers array
     *
     * @return array
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Setter for headers array
     *
     * @param string $key
     * @param string|array $value
     * @return $this
     */
    protected function setHeader($key, $value)
    {
        $this->headers = [$key => $value];

        return $this;
    }

    /**
     * Appends a header to the headers array
     *
     * @param string $key
     * @param string|array $value
     * @return $this
     */
    protected function appendHeader($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    protected function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Getter for statusCode.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode.
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Getter for data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Getter for message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Setter for message.
     *
     * @param string $message value to set
     * @return self
     */
    protected function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Variable to add message in debug mode
     *
     * @param $debug_message
     * @return self
     */
    public function setDebugMessage($debug_message)
    {
        $this->debug_message = $debug_message;

        return $this;
    }

    protected function respondWithCommonResponse(CommonInternalResponse $response)
    {
        if ($response->error) {
            return $this->setStatusCode($response->status)
                ->setDebugMessage($response->debug_message)
                ->respondWithError($response->message);
        } else {
            return $this->setStatusCode($response->status)
                ->respondWithSuccess($response->message);
        }
    }

    /**
     * Response with the current error.
     *
     * @param string $message
     * @return mixed
     */
    protected function respondWithError($message)
    {
        if (property_exists($this, 'resource')) {
            $this->resource = ErrorResource::class;
        }

        if (config('app.debug') && trim($this->debug_message) != '') {
            $message = "{$message}. DEBUG: {$this->debug_message}";
        }
        $this->setMessage($message);

        if (!$this->hasErrors()) {
            $this->errors['message'] = $message;
        }

        return $this->respondWithItem($this);
    }

    /**
     * Returns a Successful response for a request
     *
     * @param string $message
     * @param mixed|array|null $resource
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithSuccess($message, $resource = null)
    {
        if (property_exists($this, 'resource')) {
            $this->resource = SuccessResource::class;
        }

        $this->setMessage($message);

        if (is_array($resource) && array_key_exists('data', $resource)) {
            $this->data = $resource['data'];
        } else {
            $this->data = $resource;
        }

        return $this->respondWithItem($this);
    }

    /**
     * Create a json response
     *
     * @param  mixed|string $data
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse|JsonResource
     */
    protected function response($data, array $headers = [])
    {
        $this->tries++;

        if ($data instanceof Arrayable && !$data instanceof JsonSerializable) {
            $data = $data->toArray();
        } elseif ($data instanceof Scope) {
            $data = $data->toArray();
        } elseif ($data instanceof JsonResource && !$this->hasErrors()) {
            return $data->toResponse(request())->setStatusCode($this->getStatusCode());
        } elseif (!$data instanceof Arrayable && !is_array($data) && !is_null($this->wrapper)) {
            $data = [$this->wrapper => $data];
        }
        return response()->json($data, $this->statusCode, $headers ?: $this->headers);
    }

}
