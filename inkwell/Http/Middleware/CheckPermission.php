<?php

namespace NiftyCo\Inkwell\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use NiftyCo\Inkwell\Support\Authorization;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (empty($permissions)) {
            return $next($request);
        }

        if (count($permissions) === 1) {
            Authorization::authorize($permissions[0]);
        } else {
            Authorization::authorizeAny($permissions);
        }

        return $next($request);
    }
}
