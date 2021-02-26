<?php


namespace App\Http\Middleware;


use App\Entities\User\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class VerifiedEmail
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {

        $user = User::where('email',$request->email)->firstOrFail();
        if (!$user->hasVerifiedEmail()) {
            abort(403, trans('auth.must_verify_email'));
        }
        return $next($request);
    }
}
