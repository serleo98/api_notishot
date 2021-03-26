<?php

namespace App\Entities\Note;

use App\Entities\Note\Note;
use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends BaseEntity
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resources';

    protected $fillable = [
        'id',
        'type',
        'note_id',
        'route'
    ];
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}