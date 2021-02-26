<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller\BaseController;
use App\Http\Resources\User\ProfileResource;
use App\Services\User\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    /**
     * Api Service Instance
     *
     * @var ProfileService
     */
    protected $profileService;

    /**
     * Laravel Resource Instance
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource = ProfileResource::class;

    /**
     * ProfileController constructor.
     *
     * @param ProfileService $profileService
     * @return void
     */
    public function __construct(ProfileService $profileService)
    {
        parent::__construct();

        $this->profileService = $profileService;
    }

}
