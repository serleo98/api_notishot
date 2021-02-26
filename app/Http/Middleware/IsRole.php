<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (auth::user()->isRole($role)) {
            return $next($request);
        } else {
            return $this->response([
                'error' => true,
                'errors' => [],
                'errorType' => 'exception',
                'exception' => null,
                'httpCode' => 403,
                'message' => trans('permissions.insufficient_permissions')
            ], 403);
        }
    }

    private function response($message, $status) {
        return response()->json(['error' => $message], $status);
    }
}
