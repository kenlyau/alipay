<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController 
{
    public function login($request, $response, $args)
    {
        $this->view->render($response,'auth/login.html');
        
    }
}