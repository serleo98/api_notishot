<?php

namespace App\Repositories\Comment;

use App\Core\Repositories\BaseRepository;
use App\Entities\Comment\CommentRepository;
use ;

class CommentRepositoryRepository extends BaseRepository 
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
