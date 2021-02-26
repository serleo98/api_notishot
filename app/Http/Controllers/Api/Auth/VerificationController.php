<?php

namespace App\Http\Controllers\Api\Auth;

use App\Core\Controller\BaseController;
use App\Http\Resources\Responses\VerificationResource;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Authenticated user
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $user;

    /**
     * Email verified
     * @var bool
     */
    public $verified;

    /**
     * Email resent
     * @var bool
     */
    public $resent;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        $this->verified = false;
        $this->resent = false;
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {

        if ($request->route('id') == $request->user()->getKey() &&
            $request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            $this->verified = true;
        }

        return $this->verified();
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->errorBadRequest("El email del usuario ya ha sido verificado.");
        }

        $request->user()->sendEmailVerificationNotification();

        $this->resent = true;

        return $this->verified();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function verified()
    {

        $this->user = auth()->user();

        return $this->respondWithItem($this, VerificationResource::class);
    }
}
