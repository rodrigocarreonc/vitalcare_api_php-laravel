<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request){
        if (!$request->expectsJson()) {
            return route('login');
        }

        // Agrega esta línea para APIs
        abort(response()->json(['error' => 'Unauthorized'], 401));
    }

}
