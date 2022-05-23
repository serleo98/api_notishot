<?php

namespace App\Services\User;

use App\Core\Services\BaseService;

use App\Repositories\User\ProfileRepository;
use Illuminate\Database\Eloquent\Model;


class ProfileService extends BaseService
{

    public function __construct(ProfileRepository $profileRepository)
    {
        parent::__construct($profileRepository);
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }
}
