<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Auth {
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if (empty($_SESSION['userName'])) {
            $newResponse = $response->withStatus(302)->withHeader('Location', '/auth/login');
            return $newResponse;
        }
        $response = $next($request, $response);
        return $response;
    }
}