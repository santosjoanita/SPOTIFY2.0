<?php
namespace app\controllers;

use app\core\Controller;
use app\models\User; // Importante: usar o Model criado acima

class Auth extends Controller {

    public function login() {
        // Se já estiver logado, manda para a Home
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Usa o método do Model User
            $user = User::checkLogin($email, $password);

            if ($user) {
                // Login com sucesso
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role']; // admin ou guest

                header('Location: /pw/tab1_pw/SPOTIFY2.0/');
                exit;
            } else {
                // Erro
                $this->view('auth/login', ['error' => 'Email ou password incorretos']);
                return;
            }
        }

        // GET: mostra o formulário (Sem Header)
        $this->view('auth/login');
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: /pw/tab1_pw/SPOTIFY2.0/');
        exit;
    }
}