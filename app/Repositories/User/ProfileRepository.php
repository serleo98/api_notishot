<?php

namespace App\Repositories\User;

use App\Core\Repositories\BaseRepository;
use App\Entities\User\Profile;
use App\Entities\User\User;

class ProfileRepository extends BaseRepository
{
    protected $profileRepository;
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }

    public function setProfileTo( User $user, Profile $profile){
        $user->profile()->save($profile);
    }

    public function updateProfileTo(Profile $profile,Array $data){
        $profile->update($data);
    }
    
    public function deleteProfile($user)
    {
        return $this->profileRepository->where('user_id', intval($user->id))->delete();

    }
}
