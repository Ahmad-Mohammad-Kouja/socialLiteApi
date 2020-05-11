<?php

namespace App\Http\Middleware;

use App\Classes\ResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws AuthenticationException
     */
    protected function redirectTo($request)
    {
        throw new HttpResponseException(
            ResponseHelper::tokenMissMatch()
        );
    }
}
