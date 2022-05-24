<?php
namespace App\Services\User;


use Carbon\Carbon;
use App\Entities\User\User;
use App\Entities\User\Profile;
use App\Core\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\User\UserRepository;
use App\Repositories\User\ProfileRepository;
use App\Interfaces\Services\User\UserServiceInterface;


class UserService extends BaseService implements UserServiceInterface
{

    protected $profileRepository;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->localRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    public function store(array $data) : Model{
        
        $created_user = $this->localRepository->store($data);
        if(isset($data['profile'])){
            $profile = new Profile($data['profile']);
            $profile->accepted = true;
            $profile->accepted_by = Auth::check() ?  auth('api')->user()->id : null;
            $profile->accepted_at = Carbon::now()->toDateString();
            $this->profileRepository->store($profile);
        }
        return $created_user;

    }

    public function userList($toFind = null)
    {
        return $this->localRepository->getUsers($toFind);
    }

    public function update($user, Array $data) : String
    {
        $this->localRepository->updateUser($user, $data);
        $freshUser= User::find($user->fresh()->id);
        $this->profileRepository->setProfileTo($freshUser['profile'],$data['profile']);
        return trans('common.updated_user');
    }

    public function destroy($user)
    {
        $message = 'No se ha podido eliminar intente luego';
        if(is_null($user->profile))
        {
            $this->profileRepository->deleteProfile($user);
        }
        $this->localRepository->deleteUser($user);
        $message = 'Ha sido eliminado con exito';
        return $message;
    }
    public function registro (Array $data)
    {
        $data['role_id'] = 4;
        $this->store($data);
        return trans('common.register_user');
    }
}

