<?php

namespace App\Http\Middleware;

class RestfulApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if (is_array($response->original)
            && count($response->original) === 3
            && array_key_exists('code', $response->original)
            && array_key_exists('msg', $response->original)
            && array_key_exists('data', $response->original)
        ) {
            return $response;
        }

        $response->setContent(build_api_return($response->original));

        return $response;
    }
}
