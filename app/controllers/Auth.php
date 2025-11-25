<?php
namespace app\controllers;
<<<<<<< HEAD

use app\core\Controller;
use app\models\User; // Importante: usar o Model criado acima
=======
if(!isset($_SESSION)) { session_start(); } // <--- ADICIONA ESTA LINHA AQUI

use app\core\Controller;
use app\models\User;
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05

class Auth extends Controller {

    public function login() {
<<<<<<< HEAD
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
=======
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
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
        exit;
    }
}