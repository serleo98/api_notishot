<?php

namespace App\Http\Middleware;

use App\Entities\User\User;
use Closure;

class HasModule
{
    /**
     * @var string
     */
    protected $request_module;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $request_module
     * @return mixed
     */
    public function handle($request, Closure $next, $request_module)
    {
        $this->request_module = $request_module;

        if (!$this->check()) {
            return response()->json(['error' => 'Unauthorized', 'req' => $request_module, 'user' => auth()->user() ], 401);
        }

        return $next($request);
    }

    private function check() {
        return User::hasModule(auth()->user()->id, $this->request_module);
    }
}
