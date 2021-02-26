<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails {
        sendResetLinkResponse as protected tSendResetLinkResponse;
        sendResetLinkFailedResponse as protected tSendResetLinkFailedResponse;
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

    protected function sendResetLinkResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return $this->respondWithSuccess(trans($response));
        }
        return $this->tSendResetLinkResponse($request, $response);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return $this->setErrors(['email' => trans($response)])->errorBadRequest(trans($response));
        }
        return $this->tSendResetLinkFailedResponse($request, $response);
    }
}
