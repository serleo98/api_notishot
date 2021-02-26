<?php

namespace App\Services\Note;

use App\Entities\Note\Note;
use App\Entities\User\User;
use App\Core\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Note\NoteRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Note\CategoryRepository;

class NoteService extends BaseService 
{
    public function __construct(UserRepository $userRepository,NoteRepository $NoteRepository, CategoryRepository $categoryRepository)
    {
        $this->noteRepository = $NoteRepository;
        $this->localRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function store(array $data) : Model
    {
        $data['user_id'] = auth('api')->user()->id;
        return $this->noteRepository->store($data);
    }

    public function noteLists()
    {
        $userAuth = auth('api')->user()->id;
        return $this->noteRepository->getNotes($userAuth);
    }
}