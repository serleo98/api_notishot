<?php

namespace App\Services\Note;

use App\Entities\Note\Note;
use App\Core\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Note\ResourceRepository;

class ResourceService extends BaseService 
{
    /**
     * ResourceService constructor.
     *
     * @param ResourceRepository $resourceRepository
     * @return void
     */
    public function __construct(ResourceRepository $resourceRepository)
    {
        parent::__construct($resourceRepository);
    }
}