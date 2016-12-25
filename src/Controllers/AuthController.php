<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController 
{
    public function login($request, $response, $args)
    {
        if ($_SESSION['userName']){
            return $this->redirect($response, '/manage');
        }
        $this->view->render($response,'auth/login.html');
        
    }

    public function loginDo($request, $response, $args)
    {
        $bodyParams = $request->getParsedBody();
        $user = User::where('name','=', $bodyParams['name'])->first();
        if (empty($user)){
           return $this->redirect($response, '/auth');
        }
        if (sha1($bodyParams['pass']) != $user['pass']) {
           return $this->redirect($response, '/auth');
        }
        $_SESSION['userName'] = $user['name'];
        $_SESSION['userId'] = $user['id'];
        
        return $this->redirect($response, '/manage');

    }
    
    public function loginOut($request, $response, $args)
    {
        session_destroy();
        return $this->redirect($response, '/auth');
    }
}