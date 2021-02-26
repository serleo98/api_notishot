<?php

namespace App\Core\Policies;

use App\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    protected $MODULE = 'MODULE';

    protected static $SHOW = 'VIEW';
    protected static $STORE = 'ADD';
    protected static $UPDATE = 'UPDATE';
    protected static $DESTROY = 'DELETE';

    /**
     * @param User|null $user
     * @return bool
     */
    public function index($user = null)
    {
        return $this->can($user, $this->doView());
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function show($user = null)
    {
        return $this->can($user, $this->doView());
    }

    public function store(User $user)
    {
        return $this->can($user, $this->doAdd());
    }

    public function update(User $user)
    {
        return $this->can($user, $this->doUpdate());
    }

    public function destroy(User $user)
    {
        return $this->can($user, $this->doDelete());
    }

    protected function can(User $user, string $module_name) {
        return User::hasModule($user->id, $module_name);
    }

    protected function doView(): string
    {
        return $this->MODULE . '_' . self::$SHOW;
    }

    protected function doAdd(): string
    {
        return $this->MODULE . '_' . self::$STORE;
    }

    protected function doUpdate(): string
    {
        return $this->MODULE . '_' . self::$UPDATE;
    }

    protected function doDelete(): string
    {
        return $this->MODULE . '_' . self::$DESTROY;
    }


}