<?php

namespace App\Repositories\Note;

use App\Entities\Note\Note;
use Illuminate\Database\Eloquent\Model;
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
    public function show($note)
    {
        return $this->model->find($note->id);
    }
    public function deleteNote ($note)
    {
        return $note->delete();
    }
    public function showall()
    {
        return $this->model->all();
    }
}
