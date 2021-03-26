<?php

namespace App\Services\Note;

use App\Entities\Note\Note;
use App\Entities\User\User;
use App\Entities\Note\Resource;
use App\Core\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Note\NoteRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Note\CategoryRepository;
use App\Repositories\Note\ResourceRepository;

class NoteService extends BaseService 
{
    public function __construct(CategoryRepository $categoryRepository,NoteRepository $noteRepository, ResourceRepository $resourceRepository)
    {
        
        $this->localRepository = $noteRepository;
        $this->resourceRepository = $resourceRepository;
        $this->categoryRepository = $categoryRepository;
    
    }

    public function store(array $data) : Model
    {
        dd($data);
        $data['user_id'] = auth('api')->user()->id;
        $created_note = [];
        if(isset($data['resource'])){
            $created_note = $this->noteRepository->store($data);
            $resource = new Resource($data['resource']);
            $this->resourceRepository->setResourceTo($created_note, $resource);
        };
        return $created_note;
    }

    public function noteLists()
    {
        $userAuth = auth('api')->user()->id;
        return $this->noteRepository->getNotes($userAuth);
    }
    public function show($note)
    {
        return $this->noteRepository->show($note);
    }
    public function showall()
    {
        return $this->noteRepository->showall();
    }
    public function update(Note $note,array $data)
    { 
        $this->noteRepository->update($data,$note);
        return trans('common.updated_note');
    }
    public function deleteNote(Note $note)
    {
        $this->noteRepository->deleteNote($note);
        return trans('common.destroy_note');
    }
}