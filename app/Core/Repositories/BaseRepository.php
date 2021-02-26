<?php

namespace App\Core\Repositories;

use App\Core\Entities\BaseEntity;
use App\Core\Traits\Validations;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository
{
    use Validations;

    protected $model;

    /**
     * BaseRepository constructor.
     * @param BaseEntity $model
     */
    public function __construct(BaseEntity $model)
    {
        $this->model = $model;
    }

    /**
     * Get a model instance
     * @return BaseEntity
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return EloquentQueryBuilder
     */
    protected function newQuery()
    {
        return QueryBuilder::for($this->getModel()->getMorphClass())
            ->allowedIncludes($this->getModel()->allowed_includes)
            ->allowedFilters($this->getModel()->allowed_filters)
            ->allowedAppends($this->getModel()->allowed_appends)
            ->allowedSorts($this->getModel()->allowed_sorts);
    }

    /**
     * @param EloquentQueryBuilder $query
     * @param int $take
     * @param bool $paginate
     *
     * @return EloquentCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate) {
            return $query->paginate($take);
        }

        if (is_numeric($take) && $take > 0) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return EloquentCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->model->all();
    }

    /**
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Store method
     * @param array $attributes
     * @return Model
     */
    public function store(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update method
     * @param array $attributes
     * @param Model $model
     * @return Model
     */
    public function update(array $attributes, Model $model): Model
    {
        $model->fill($attributes);

        $model->save();

        return $model;
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int $id
     * @param bool $fail
     *
     * @return Model
     */
    public function findByID($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }
        return $this->newQuery()->find($id);
    }

    /**
     * Retrieves the first record by values
     * values => [field => value]
     *
     * @param array $values
     * @param bool $fail
     *
     * @return Model
     */
    public function findByValues(array $values)
    {
        return $this->newQuery()->where($values)->first();
    }

    public function findOrCreateBy($findElement, $data, $where){

    $object = $this->findByValues([$where => $data[$findElement]]);
        if(!isset($object->id)){
            $object = $this->store($data);
        }
        return $object;
    }
}
