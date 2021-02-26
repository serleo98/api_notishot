<?php

namespace App\Core\Entities\Traits;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait QueryFilter
{
    /**
     * The sort available attributes.
     *
     * @var array
     */
    public $allowed_sorts = [];

    /**
     * The default includes for the model
     *
     * @var array
     */
    public $default_includes = [];

    /**
     * The available includes for the model
     *
     * @var array
     */
    public $allowed_includes = [];

    /**
     * The allowed filters for the model
     *
     * @var array
     */
    public $allowed_filters = [];

    /**
     * The allowed appends for the model
     *
     * @var array
     */
    public $allowed_appends = [];

    /**
     * @param Builder $query
     * @param string $relation
     * @param Closure|null $callback
     * @return mixed
     */
    public function scopeWithAndWhereHas($query, $relation, Closure $callback = null)
    {
        return $query->whereHas($relation, $callback)->with([$relation => $callback]);
    }
}