<?php

namespace App\Entities\Comment;
use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseEntity
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    protected $fillable = [
        'id',
        'user_id',
        'note_id',
        'nick_name',
        'body',
        'status'
        ];
    
    //
}
