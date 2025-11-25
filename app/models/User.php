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
            return $result[0]; // Retorna o primeiro utilizador encontrado
        }
        return null;
    }

    // Verifica login (suporta texto simples ou hash)
    public static function checkLogin($email, $password) {
        $user = self::findByEmail($email);

        if ($user) {
            // Verifica se a password coincide (Hash ou Texto Simples)
            // Nota: password_verify retorna true se for hash válido, a segunda parte é para passwords 'admin1234' em texto simples
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}