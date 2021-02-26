<?php

namespace App\Http\Controllers\Api\Note;

use Illuminate\Http\Request;
use App\Services\Note\NoteService;
use App\Http\Controllers\Controller;
use App\Core\Controller\BaseController;
use App\Http\Requests\Note\NoteRequest;
use App\Http\Resources\Note\NoteResource;

class NoteController extends BaseController
{
    protected $resource = NoteResource::class;
    protected $noteService;
    public function __construct (NoteService $noteService)
    {
        parent::__construct();
        $this->noteService = $noteService;
    }
    public function store(NoteRequest $request)
    {
        $this->noteService->store($request->all());
        return $this->respondWithSuccess('ok');
    }
    public function index()
    {
        return $this->respondWithCollection($this->noteService->noteLists());
    }

    public function update(NoteRequest $request, Note $note)
    {
        
    }
}
