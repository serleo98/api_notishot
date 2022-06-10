<?php

namespace App\Repositories\Comment;

use App\Core\Repositories\BaseRepository;

class CommentRepository extends BaseRepository 
{
    /**
     * CommentRepositoryRepository constructor.
     *
     * @param CommentRepository $commentRepository
     * @return void
     */
    public function __construct(CommentRepository $commentRepository)
    {
        parent::__construct($commentRepository);
    }
}
