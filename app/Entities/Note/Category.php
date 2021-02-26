<?php

namespace App\Entities\Note;

use App\Entities\Note\Note;
use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseEntity
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'description',
        'status'
        ];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
