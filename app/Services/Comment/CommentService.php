<?php

namespace App\Services\Comment;

use App\Core\Services\BaseService;
use App\Repositories\Comment\CommentRepository;

class CommentService extends BaseService 
{
    /**
     * CommentServiceService constructor.
     *
     * @param CommentService $commentRepository
     * @return void
     */
    public function __construct(CommentService $commentRepository)
    {
        parent::__construct($commentRepository);
    }
}
