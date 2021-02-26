<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use App\Entities\User\User;
use App\Http\Controllers\Api\Auth\Traits\LoggedUser;
use App\Http\Resources\Responses\LoginClientResource;
use App\Http\Resources\Responses\LoginResource;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    protected $resource = LoginResource::class;

    use LoggedUser, ResetsPasswords {
        sendResetResponse as protected tSendResetResponse;
        sendResetFailedResponse as protected tSendResetFailedResponse;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function loginUser(Request $request)
    {
        $user = User::where('email', $request->only('email'))->first();

        auth()->login($user);

        $this->validateLogInUser($request);

        $user = auth()->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();


//        return $this->respondWithItem($tokenResult, LoginClientResource::class);
        return $this->respondWithItem($tokenResult);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return $this->loginUser($request);
        }
        return $this->tSendResetResponse($request, $response);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return $this->setErrors(['email' => trans($response)])->errorBadRequest(trans($response));
        }
        return $this->tSendResetFailedResponse($request, $response);
    }
}
