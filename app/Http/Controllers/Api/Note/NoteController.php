<?php

namespace App\Http\Controllers\Api\Note;

use App\Entities\Note\Note;
use App\Entities\User\User;
use Illuminate\Http\Request;
use App\Services\Note\NoteService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Core\Controller\BaseController;
use App\Http\Requests\Note\NoteRequest;
use App\Http\Resources\Note\NoteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteController extends BaseController
{
    protected $noteService;
      /**
     * Laravel Resource Instance
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource = NoteResource::class;

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
        $notes= $this->noteservice-> noteLists();
        return $this-> respondWithCollection($notes);
    }

    public function show(Note $note)
    {

        return $this->respondWithItem($this->noteService->show($note));
    }
    public function showall()
    {
        return $this->respondWithCollection($this->noteService->showall());
    }

    public function update(NoteRequest $request, $note)
    {
        $nota = Note::where('id',$note)->first();
        $userAuth = User::find(Auth::user()->id);
        if( $userAuth->id != $nota->user_id)
            {
                return $this->respondWithError(trans('permissions.insufficient_permissions'));
            }
        else return $this->respondWithSuccess($this->noteService->update($request->all(),$nota));
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
