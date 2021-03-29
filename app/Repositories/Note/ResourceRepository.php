<?php

namespace App\Repositories\Note;

use App\Entities\Note\Note;
use App\Entities\Note\Resource;
use App\Core\Repositories\BaseRepository;

class ResourceRepository extends BaseRepository 
{
    protected $resourceRepository;

    public function __construct(Resource $resource)
    {
        parent::__construct($resource);
    }
    
    public function setResourceTo( Note $note, Resource $resource){
        $note->resources()->save($resource);
    }
}