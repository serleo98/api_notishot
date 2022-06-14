<?php

namespace App\Http\Controllers\Api\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Controller\BaseController;
use App\Services\Comment\CommentService;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends BaseController
{
    protected $commentService;
      /**
     * Laravel Resource Instance
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource = CommentResource::class;

    public function __construct (CommentService $commentService)
    {
        parent::__construct();

        $this->commentService = $commentService;
    }
}
