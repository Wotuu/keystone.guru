<?php

namespace App\Http\Middleware;

use App\Service\User\UserServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Teapot\StatusCode;

class ApiAuthentication
{
    public function __construct(private readonly UserServiceInterface $userService)
    {
    }

    /**
     * Handle an incoming request.
     *
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->userService->loginAsUserFromAuthenticationHeader($request)) {
            return response()->json(['error' => __('exceptions.handler.unauthenticated')], StatusCode::UNAUTHORIZED);
        }

        return $next($request);
    }
}
