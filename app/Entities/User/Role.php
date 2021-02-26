<?php

namespace App\Entities\User;

use App\Core\Entities\BaseEntity;

class Role extends BaseEntity
{
    private static $_SUPER = 'superadmin';
    private static $_ADMINISTRATOR = 'administrador';
    private static $_MODERATOR = 'moderador';
    private static $_READER = 'lector';
    private static $_WRITER = 'redactor';


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public static function superAdminKey() {
        return self::$_SUPER;
    }

    public static function adminKey() {
        return self::$_ADMINISTRATOR;
    }

    public static function moderatorKey() {
        return self::$_MODERATOR;
    }

    public static function readerKey() {
        return self::$_READER;
    }

    public static function writerKey() {
        return self::$_WRITER;
    }

}
