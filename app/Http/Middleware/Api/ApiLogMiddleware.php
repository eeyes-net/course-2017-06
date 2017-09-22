<?php

namespace App\Http\Middleware\Api;

use App\ApiLog;
use Closure;
use Illuminate\Http\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('settings.api_log')) {
            $apiLog = new ApiLog();
            $apiLog->path = $request->path();
            $apiLog->method = $request->method();
            $apiLog->ip = $request->ip();
            $apiLog->user_agent = (string)$request->userAgent();
            $apiLog->query = (string)$request->getQueryString();
            $apiLog->body = (string)$request->getContent();
            $apiLog->save();
        }

        /** @var Response $response */
        $response = $next($request);

        // if (isset($apiLog)) {
        //     $apiLog->response = json_encode($response->getOriginalContent(), JSON_UNESCAPED_UNICODE);
        //     $apiLog->save();
        // }

        return $response;
    }
}
