<?php

namespace App\Services\Comment;

use App\Core\Services\BaseService;
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
    public function __construct(CommentService $commentRepository)
    {
        parent::__construct($commentRepository);
    }
}
