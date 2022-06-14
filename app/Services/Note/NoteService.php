<?php

namespace App\Services\Note;

use App\Entities\Note\Note;
use App\Entities\User\User;
use Illuminate\Support\Carbon;
use App\Entities\Note\Resource;
use App\Core\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Note\NoteRepository;
use App\Repositories\Note\CategoryRepository;
use App\Repositories\Note\ResourceRepository;
use App\Interfaces\Services\Note\NoteServiceInterface;

class NoteService extends BaseService implements NoteServiceInterface
{
    public function __construct(CategoryRepository $categoryRepository,NoteRepository $noteRepository, ResourceRepository $resourceRepository)
    {
        
        $this->noteRepository = $noteRepository;
        $this->resourceRepository = $resourceRepository;
        $this->categoryRepository = $categoryRepository;
    
    }

    public function store(array $data) : Model
    {
        $data['user_id'] = auth('api')->user()->id;
        $created_note = $this->noteRepository->store($data); 
        if(isset($data['resource'])){
            $path = Storage::putFileAs('/public/resource/imagenes',$data['resource'],Carbon::now()->format('YmdHis').'.jpg');
            $ext = File::extension($path);
            $aux['note_id'] = $created_note->id;
            $aux['type'] = $ext;
            $aux['route']  = Storage::url($path);
            $this->resourceRepository->store($aux);  
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
    public function update(array $data,Note $note)
    { 
        $this->noteRepository->update($data,$note);
        $recurso = Resource::where('note_id',$note->id)->first();
        isset($data['resource']) ? $this->resourceRepository->update($data['resource'],$recurso) : null ;
        return trans('common.updated_note');
    }
    public function deleteNote(Note $note)
    {
        $this->noteRepository->deleteNote($note);
        return trans('common.destroy_note');
    }
}