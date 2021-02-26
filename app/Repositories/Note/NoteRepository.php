<?php

namespace App\Repositories\Note;

use App\Entities\Note\Note;
use App\Core\Repositories\BaseRepository;
use App\Interfaces\Repositories\Note\NoteRepositoryInterface;

class NoteRepository extends BaseRepository implements NoteRepositoryInterface
{
    /**
     * NoteRepository constructor.
     *
     * @param NoteRepository $noteRepository
     * @return void
     */
    public function __construct(Note $note)
    {
        $this->model = $note;
    }
    public function getNotes($user)
    {
        return $this->model->all()->where('user_id',$user);
    }
}
