<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonInputParser
{
    /**
     * Handle an possible incoming JSON request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $contentType = $request->header('content-type');
        if ($contentType !== 'application/json') {
            return $next($request);
        }

        $request->merge($request->json()->all());
        return $next($request);
    }
}
