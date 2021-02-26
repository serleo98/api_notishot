<?php

namespace App\Core\Entities;

use App\Core\Entities\Traits\QueryFilter;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEntity extends Model
{
    use QueryFilter;

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed $value
     * @return \Illuminate\Support\Carbon
     */
    protected function asDateTime($value)
    {
        try {
            return parent::asDateTime($value);
        } catch (\Exception $e) {
            return Carbon::parse($value);
        }
    }
}
