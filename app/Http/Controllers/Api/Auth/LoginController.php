<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use App\Entities\User\User;
use App\Http\Controllers\Api\Auth\Traits\LoggedUser;
use App\Http\Resources\Responses\LoginResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, LoggedUser;

    /**
     * @var string
     */
    protected $resource = LoginResource::class;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth:api')->except('login');
    }

    /**
     * Get a JWT via given credentials.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        try {
            if (!Auth::guard('web')->attempt($this->credentials($request))) {
                return $this->errorUnauthorized(trans('auth.failed'));
            }
        } catch (\Exception $e) {
            return $this->errorInternalError(trans('auth.token_fail'));
        }

        return $this->respondWithItem($this->createToken($request));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (auth()->check()) {
            foreach (auth()->user()->tokens as $token) {
                $token->revoke();
            }
        }

        return $this->setStatusCode(200)->respondWithSuccess(trans('auth.logout'));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithItem(auth()->refresh());
    }
}
