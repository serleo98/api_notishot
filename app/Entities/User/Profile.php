<?php

namespace App\Entities\User;

use App\Core\Entities\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends BaseEntity
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'last_name',
        'cel_phone',
        'phone',
        'profile_photo',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'blog_personal_url',
        'city',
        'province',
        'country',
        'postal_code',
        'accepted',
        'accepted_by',
        'accepted_at'
    ];

    public function acceptedBy(){
        return $this->hasOne(User::class, 'id', 'accepted_by');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
