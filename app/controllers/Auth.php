<?php
namespace app\controllers;

use app\core\Controller;
use app\models\User; //Tem de usar o model user ao fazer login, para obter as credenciais corretas.

class Auth extends Controller {

    public function login() {
        // Se o user já tiver login feito, vai para a página home
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // vai á função checklogin do model do user 
            $user = User::checkLogin($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role']; // admin ou guest

                header('Location: /pw/tab1_pw/SPOTIFY2.0/');
                exit;
            } else {
                $this->view('auth/login', ['error' => 'Email ou password incorretos']);
                return;
            }
        }

        // GET: mostra o forms
        $this->view('auth/login');
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: /pw/tab1_pw/SPOTIFY2.0/');
        exit;
    }
}