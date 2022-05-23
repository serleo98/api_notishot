<?php

namespace App\Services\Comment;

use App\Core\Services\BaseService;
use App\Repositories\Comment\CommentServiceRepository;
use ;

class CommentServiceService extends BaseService 
{
    /**
     * CommentServiceService constructor.
     *
     * @param CommentServiceRepository $commentServiceRepository
     * @return void
     */
    public function __construct(CommentServiceRepository $commentServiceRepository)
    {
        parent::__construct($commentServiceRepository);
    }
}
