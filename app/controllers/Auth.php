<?php
namespace app\controllers;
if(!isset($_SESSION)) { session_start(); } // <--- ADICIONA ESTA LINHA AQUI

use app\core\Controller;
use app\models\User;

class Auth extends Controller {

    public function login() {
        // Se já estiver logado, manda para a lista de músicas
        if (isset($_SESSION['user_id'])) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
            exit;
        }
        $this->view('auth/login');
    }

    public function check() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $pass = $_POST['password'];

            // Verifica na Base de Dados
            $user = User::checkLogin($email, $pass);

            if ($user) {
                // SUCESSO: Guardar dados na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role']; // Aqui guardamos se é 'admin' ou 'guest'
                
                // Redirecionar para a HOME (Lista de Músicas)
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
                exit;
            } else {
                // FALHA: Volta ao login com erro
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Auth/login?error=true');
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Auth/login');
        exit;
    }
}