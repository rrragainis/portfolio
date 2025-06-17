<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleCors
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('CORS Middleware - Request received', [
            'method' => $request->method(),
            'path' => $request->path(),
            'headers' => $request->headers->all(),
            'origin' => $request->header('Origin')
        ]);

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Authorization, X-CSRF-TOKEN');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', '1728000');

        if ($request->isMethod('OPTIONS')) {
            Log::info('CORS Middleware - Handling OPTIONS request');
            $response->setStatusCode(200);
            $response->setContent('');
        }

        Log::info('CORS Middleware - Response headers', [
            'headers' => $response->headers->all()
        ]);

        return $response;
    }
} 