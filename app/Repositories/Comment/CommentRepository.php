<?php

namespace App\Repositories\Comment;

use App\Entities\Comment\Comment;
use App\Core\Repositories\BaseRepository;
use App\Interfaces\Repositories\Comment\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepositoryRepository constructor.
     *
     * @param CommentRepository $commentRepository
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}
