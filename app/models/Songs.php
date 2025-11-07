<?php
namespace app\models;
use app\core\Db;

class Songs {
    public static function getAllSongs() {
        $db = new Db();
        $sql = "SELECT s.id, s.title, a.name AS artist, s.album, s.genre, s.year, s.duration
                FROM songs s
                LEFT JOIN artists a ON s.artist_id = a.id";
        return $db->execQuery($sql);
    }
}


?>
