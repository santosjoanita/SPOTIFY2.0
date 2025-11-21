<?php
namespace app\models;
use app\core\Db;

class Songs {
    public static function getAllSongs() {
        $db = new Db();
        // Use a generic SELECT * to be tolerant to small schema differences in local DBs
        $sql = "SELECT * FROM songs ORDER BY id DESC";
        return $db->execQuery($sql);
    }

    public static function createSong(array $data) {
        $db = new Db();
        $sql = 'INSERT INTO songs (title, artist, album, genre_id, year, cover_url) VALUES (?, ?, ?, ?, ?, ?)';
        $params = ['ssssss', [
            $data['title'] ?? null,
            $data['artist'] ?? null,
            $data['album'] ?? null,
            isset($data['genre_id']) ? $data['genre_id'] : null,
            $data['year'] ?? null,
            $data['cover_url'] ?? null
        ]];
        $insertId = $db->execQuery($sql, $params);
        return $insertId;
    }

    public static function updateSong(int $id, array $data) {
        $db = new Db();
        $sql = 'UPDATE songs SET title = ?, artist = ?, album = ?, genre_id = ?, year = ?, cover_url = ? WHERE id = ?';
        $params = ['ssssssi', [
            $data['title'] ?? null,
            $data['artist'] ?? null,
            $data['album'] ?? null,
            isset($data['genre_id']) ? $data['genre_id'] : null,
            $data['year'] ?? null,
            $data['cover_url'] ?? null,
            $id
        ]];
        $res = $db->execQuery($sql, $params);
        return $res;
    }

    public static function deleteSong($id) {
        $db = new Db();
        $sql = 'DELETE FROM songs WHERE id = ?';
        $params = ['i', [$id]];
        $rows = $db->execQuery($sql, $params);
        return $rows;
    }
}


?>
