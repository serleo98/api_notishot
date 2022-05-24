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
    
    public function deleteProfile($user)
    {
        return $user->profile->delete();
    }
}
