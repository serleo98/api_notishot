<?php

namespace App\Http\Controllers\Api\Comment;

use App\Entities\Note\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Controller\BaseController;
use App\Services\Comment\CommentService;
use App\Http\Requests\Comment\CommentRequest;
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
    public function store(CommentRequest $request)
    {
        $this->commentService->store($request->all());
        return $this->respondWithSuccess('ok');
    }


    public function index()
    {
        $notes= $this->noteService-> noteLists();
        return $this-> respondWithCollection($notes);
    }

    public function show(Note $note)
    {

        return $this->respondWithItem($this->noteService->show($note));
    }
}
