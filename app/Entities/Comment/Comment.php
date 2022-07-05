<?php

namespace App\Entities\Comment;
use App\Entities\Note\Note;
use App\Entities\User\User;

use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
