<?php namespace App\Http\Middleware;

use App\Service\ReadOnlyMode\ReadOnlyModeServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Teapot\StatusCode\Http;

class ReadOnlyMode
{
    public function __construct(private ReadOnlyModeServiceInterface $readOnlyModeService)
    {
    }


    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() !== 'GET' && $this->readOnlyModeService->isReadOnly()) {
            return response('Service Unavailable - site is in read-only mode', Http::SERVICE_UNAVAILABLE);
        }

        return $next($request);
    }
}
