<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {

            return response()
                ->json(['status' => 'Token is Invalid']);
        } catch (TokenExpiredException $e) {

            return response()
                ->json(['status' => 'Token is Expired']);
        } catch (Throwable $th) {

            return response()
                ->json(['status' => 'Authorization Token not found'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
