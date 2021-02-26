<?php

namespace App\Services\Note;

use App\Core\Services\BaseService;
use App\Repositories\Note\CategoryRepository;

class CategoryService  extends BaseService 
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
    }
}
