<?php

namespace App\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseServiceInterface
{
    public function one(int $id): Model;

    public function listPaginated(int $pageSize, $sorted, $sortedBy, $sortedOrder, array $where): LengthAwarePaginator;

    public function store(array $data): ?Model;
}
