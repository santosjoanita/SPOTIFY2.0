<?php
namespace app\models;

use app\core\Db;

class User {
    // Procura utilizador por email
    public static function findByEmail($email) {
        $db = new Db();
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $db->execQuery($sql, ['s', [$email]]);

        if (!empty($result)) {
            return $result[0]; 
        }
        return null;
    }

    // Verifica login 
    public static function checkLogin($email, $password) {
        $user = self::findByEmail($email);

        if ($user) {
            // Verifica se a password coincide (Hash ou Texto Simples)
            
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}