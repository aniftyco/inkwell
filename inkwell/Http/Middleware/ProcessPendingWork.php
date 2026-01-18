<?php

namespace NiftyCo\Inkwell\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use NiftyCo\Inkwell\Support\PendingWork;
use Symfony\Component\HttpFoundation\Response;

class ProcessPendingWork
{
    public function __construct(protected PendingWork $pendingWork)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->pendingWork->process();
    }
}
