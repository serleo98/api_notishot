<?php

namespace App\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class CommonInternalResponse
{
    /**
     * @var boolean
     */
    public $error;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $debug_message;

    /**
     * @var int
     */
    public $status;

    public function __construct(bool $error = false, string $message = '', string $debug_message = '', int $status = 200, Model $data = null)
    {
        $this->error = $error;
        $this->message = $message;
        $this->debug_message = $debug_message;
        $this->status = $status;
        $this->data = $data;
    }
}
