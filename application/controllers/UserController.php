<?php

namespace application\controllers;

use application\models\User;
use application\core\Controller;
use application\core\View;

class UserController extends Controller
{
    private $mainmodel;

    public function mainAction()
    {
        $vars = [
            'block' => 'auth',
            'path' => $this->path,
            'status' => $this->userstatus
        ];
        $this->render = new View;
        $this->render->render($vars);
    }

    public function loginAction()
    {
        $this->mainmodel = new User;
        $this->render = new View;
        if (!empty($_POST)) {
            $post = $this->mainmodel->validateLogin($_POST);
            $par = require './application/config/admin.php';
            if ((($par['login']) == $post['login']) && (($par['password']) == $post['password'])) {
                $_SESSION = [
                    'auth' => 1
                ];
                $this->render->message('success', 'Вы успешно авторизовались');
            } else {
                $this->render->message('error', 'Ошибка: неправильный логин или пароль');
            }
        } else {
            $this->render->message('error', 'Ошибка: Вы не заполнили данные');
        }
    }

    public function logoutAction()
    {
        session_unset();
        session_destroy();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-86400, '/');
        }
        $redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'/'; 
        header("Location: $redirect");
        exit;
    }

}