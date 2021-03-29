<?php

namespace App\Http\Controllers\Api\Note;

use App\Entities\Note\Note;
use Illuminate\Http\Request;
use App\Services\Note\NoteService;
use App\Http\Controllers\Controller;
use App\Core\Controller\BaseController;
use App\Http\Requests\Note\NoteRequest;
use App\Http\Resources\Note\NoteResource;

class NoteController extends BaseController
{
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

    public function show(Note $note)
    {
        return $this->respondWithCollection($this->noteService->show($note));
    }
    public function showall()
    {
        return $this->respondWithCollection($this->noteService->showall());
    }

    public function update(NoteRequest $request, Note $note)
    {
        $userAuth = auth('api')->user()->id;
        if( $userAuth != $note->user->id)
            {
                return $this->respondWithError(trans('permissions.insufficient_permissions'));
            }   
        else return $this->respondWithSuccess($this->noteService->update($note,$request->all()));
    }
    public function destroy(Note $note)
    {
        $userAuth = auth('api')->user()->id;
        if( $userAuth != $note->user->id)
            {
                return $this->respondWithError(trans('permissions.insufficient_permissions'));
            }   
        else return $this->respondWithSuccess($this->noteService->deleteNote($note));
    }
}