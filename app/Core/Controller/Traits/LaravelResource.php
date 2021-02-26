<?php

namespace App\Core\Controller\Traits;

/**
 * Trait Resource
 * @package App\Core\Controller\Traits
 */
trait LaravelResource
{
    /**
     * Laravel Resource Instance
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource;

    /**
     * Instantiate a laravel resource from a eloquent model instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $modelInstance
     * @param \Illuminate\Http\Resources\Json\JsonResource|null $jsonResource
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function item($modelInstance, $jsonResource = null)
    {
        if (!is_null($jsonResource)) {
            $resource = $jsonResource::make($modelInstance);
        } else {
            $resource = $this->resource::make($modelInstance);
        }

        return $resource;
    }

    /**
     * Create collection using laravel resources as schema for each item.
     *
     * @param $collection
     * @param \Illuminate\Http\Resources\Json\JsonResource|null $jsonResource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function collection($collection, $jsonResource = null)
    {
        if (!is_null($jsonResource)) {
            $resource = $jsonResource::collection($collection);
        } else {
            $resource = $this->resource::collection($collection);
        }
        return $resource;
    }

}
