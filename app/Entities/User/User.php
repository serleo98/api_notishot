<?php

namespace App\Entities\User;

use App\Entities\Note\Note;
use App\Entities\Comment\Comment;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Core\Entities\Traits\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes, QueryFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nick_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'profile_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function notes ()
    {
        return $this->hasMany(Note::class);
    }
    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function isRole($role)
    {
        return $this->role->key === $role || $this->role->key === 'superadmin';
    }

    public function setPasswordAttribute($pass){

        if (Hash::needsRehash($pass)) {
            $this->attributes['password'] = Hash::make($pass);
        } else {
            $this->attributes['password'] = $pass;
        }

    }

    public function isSuperAdmin(){
        return $this->role->key === 'superadmin';
    }

    public function isWriter()
    {
        return $this->role->key ==='writer';
    }

    public function hasVerifiedEmail(){
        return !is_null($this->email_verified_at);
    }

    public function hasBeenAccepted(){
        return !(is_null($this->profile) || $this->profile->accepted === 1);
    }

}
