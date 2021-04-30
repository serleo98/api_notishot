<?php

namespace App\Http\Controllers\Api\User;

use App\Entities\User\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Core\Controller\BaseController;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    /**
     * Api Service Instance
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Laravel Resource Instance
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource = UserResource::class;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->respondWithCollection($this->userService->userList());
    }

    public function show(User $user)
    {
        if($user->isSuperAdmin() && !auth('api')->user()->isSuperAdmin()){
            return $this->respondWithError(trans('permissions.insufficient_permissions'));
        }
        return $this->respondWithItem($this->userService->showVerified($user));
    }

    public function update(UserRequest $request, User $user)
    {
        return $this->respondWithSuccess($this->userService->update($user , $request->all()));
    }

    public function store(UserRequest $request)
    {
        return $this->respondWithItem($this->userService->store($request->all()));
    }
    public function destroy(User $user)
    {
        return $this->respondWithSuccess($this->userService->destroy($user));
    }

    public function create(User $user)
    {
        return $this->errorNotImplemented();
    }
}
