<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use App\Entities\User\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password change requests
    |
    */
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:api');
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'email' => auth()->user()->email,
            'password' => $request->get('current_password')
        ];
    }

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ];
    }

    protected function password(Request $request)
    {
        return $request->only('password');
    }

    public function change(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        if (!Auth::guard('web')->attempt($this->credentials($request))) {
            return $this->errorUnauthorized(trans('auth.failed'));
        }

        /** @var User $user */
        $user = auth()->user();

        $user->update($this->password($request));

        return $this->respondWithSuccess(trans('auth.password_change'), compact('user'));
    }

}
