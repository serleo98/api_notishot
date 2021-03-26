<?php

namespace App\Entities\Note;

use App\Entities\User\User;
use App\Entities\Note\Category;
use App\Entities\Note\Resource;
use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends BaseEntity
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notes';

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'title',
        'location',
        'body',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}