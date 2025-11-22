<?php
namespace app\models;
use app\core\Db;

class User {
    public static function checkLogin($email, $password) {
        $db = new Db();
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $db->execQuery($sql, ['s', [$email]]);

        if (!empty($result)) {
            $user = $result[0];
            // Verifica a password (Hash ou Texto simples para facilitar o teu teste)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}