<?php

namespace App\Core\Repositories;

use App\Core\Entities\BaseEntity;

interface BaseRepositoryInterface
{
    public function __construct(BaseEntity $model);

    /**
     * @return BaseEntity
     */
    public function getModel(): BaseEntity;

    public function getAll($take = 15, $paginate = true);

    public function lists($column, $key = null);

    public function findByID($id, $fail = true);
}
