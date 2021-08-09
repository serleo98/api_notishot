<?php


namespace App\Repositories\User;

use App\Core\Repositories\BaseRepository;
use App\Entities\User\User;
use App\Interfaces\Repositories\User\UserRepositoryInterface;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUsers($toFind = null)
    {
        switch ($toFind) {
            case 'active':
                return $this->model->where('deleted_at', null)->where('role_id', 1)->get();
            break;
            case 'deleted':
                return $this->model->onlyTrashed()->where('role_id', 1)->get();
            break;
            default:
                return $this->model->where('role_id', '!=', 1)->get();
            break;
        }
    }
    public function updateUser($user, $data)
    {
        return $this->model->save($data);
    }
    
    public function deleteUser($user)
    {
        return $this->model->destroy($user);
    }
}
