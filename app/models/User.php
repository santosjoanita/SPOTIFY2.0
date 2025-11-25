<?php
namespace app\models;
<<<<<<< HEAD

use app\core\Db;

class User {
    // Procura utilizador por email
    public static function findByEmail($email) {
=======
use app\core\Db;

class User {
    public static function checkLogin($email, $password) {
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
        $db = new Db();
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $db->execQuery($sql, ['s', [$email]]);

        if (!empty($result)) {
<<<<<<< HEAD
            return $result[0]; // Retorna o primeiro utilizador encontrado
        }
        return null;
    }

    public static function checkLogin($email, $password) {
        $user = self::findByEmail($email);

        if ($user) {
    
=======
            $user = $result[0];
            // Verifica a password (Hash ou Texto simples para facilitar o teu teste)
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}