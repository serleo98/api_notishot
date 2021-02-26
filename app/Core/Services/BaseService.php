<?php

namespace App\Core\Services;

use App\Core\Entities\CommonInternalResponse;
use App\Core\Repositories\BaseRepository;
use App\Core\Repositories\BaseRepositoryInterface;
use App\Core\Traits\Validations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    use Validations;

    /**
     * @var BaseRepositoryInterface
     */
    protected $localRepository;

    /**
     * @var Builder
     */
    protected $query;

    public function __construct(BaseRepository $localRepository = null)
    {
        $this->localRepository = $localRepository;
    }

    public function one(int $id): Model
    {
        if (isset($this->localRepository)) {
            return $this->localRepository->findByID($id);
        } else {
            return null;
        }
    }

    /**
     * Returns all records.
     * If $take is 0 then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($take = 0, $paginate = false)
    {
        return $this->localRepository->getAll($take, $paginate);
    }

    public function listPaginated(
        int $pageSize = 15,
        $sorted = false,
        $sortedBy = '',
        $sortedOrder = '',
        array $where = []
    ): LengthAwarePaginator
    {
        if (!isset($this->localRepository)) {
            return null;
        }

        $this->query = $this->localRepository->getModel()->where($where);

        if ($sorted && $this->verifySortField($sortedBy)) {
            $this->query->orderBy($sortedBy, $sortedOrder);
        }

        return $this->paginate($pageSize);
    }

    protected function paginate(int $pageSize = 15)
    {
        if ($pageSize == 0) {
            $items = $this->query->get();
            return new LengthAwarePaginator($items, $items->count(), $items->count(), 1, []);
        }
        return $this->query->paginate($pageSize);
    }
    /**
     * @param string $field
     *
     * @return bool
     */
    public function verifySortField($field): bool
    {
        return in_array($field, $this->getAvailableSortFields());
    }

    public function getAvailableSortFields(): array
    {
        if (isset($this->localRepository) && $this->localRepository->getModel()->allowed_sorts) {
            return $this->localRepository->getModel()->allowed_sorts;
        }
        return [];
    }
    public function respondWithCommonResponse($error, $message, $code = 200) {
        return new CommonInternalResponse($error, $message, $code);
    }
}
