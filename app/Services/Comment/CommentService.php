<?php

namespace App\Services\Comment;

use App\Core\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Note\NoteRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Comment\CommentRepository;
use App\Interfaces\Services\Comment\CommentServiceInterface;

class CommentService extends BaseService implements CommentServiceInterface
{

    /**
     * CommentServiceService constructor.
     *
     * @param CommentService $commentRepository
     * @return void
     */
 
    public function __construct(UserRepository $userRepository, NoteRepository $noteRepository,CommentRepository $commentRepository)
    {
        $this->userRepository = $userRepository;
        $this->noteRepository = $noteRepository;
        $this->commentRepository = $commentRepository;
    }

    public function store(array $data) : Model
    {
        if(isset($data['body'])){
            $commentator = auth('api')->user()->id;        
            $aux['note_id'] = $created_note->id;
            $aux['type'] = $ext;
            $aux['route']  = Storage::url($path);
            $this->resourceRepository->store($aux);  
        };
        return $created_note;
    }
}
