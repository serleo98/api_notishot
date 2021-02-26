<?php

namespace App\Repositories\Note;

use App\Entities\Note\Category;
use App\Core\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository 
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
}
