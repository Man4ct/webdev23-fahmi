<?php
namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
            // if ($request->user()->role->value != $role)
        //     return abort(403);
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!in_array($request->user()->role->value, $roles))
            return abort(403);
        return $next($request);
    }
}