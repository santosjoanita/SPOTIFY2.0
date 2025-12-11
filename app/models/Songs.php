<?php
namespace app\models;
use app\core\Db;

class Songs {


    
    // TOP 3 GÉNEROS
    public static function getTopGenres() {
        $db = \app\core\Db::getInstance();        
        // Conta quantas músicas existem por género, ordena decrescente e pega os 3 primeiros
        $sql = "SELECT genres.genre, COUNT(songs.id) as total 
                FROM songs 
                JOIN genres ON songs.genre_id = genres.id 
                GROUP BY genres.genre 
                ORDER BY total DESC 
                LIMIT 3";
        return $db->execQuery($sql);
    }

    public static function getAllSongs() {
        $db = \app\core\Db::getInstance();        
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                LEFT JOIN genres ON songs.genre_id = genres.id 
                ORDER BY songs.id DESC";
        return $db->execQuery($sql);
    }

    // Pega apenas nas músicas que têm um album 
    public static function getSongsWithAlbum() {
        $db = \app\core\Db::getInstance();        
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                LEFT JOIN genres ON songs.genre_id = genres.id 
                WHERE songs.album IS NOT NULL AND songs.album != ''
                ORDER BY songs.id DESC";
        return $db->execQuery($sql);
    }

   
    public static function getSongsByGenreName($genreName) {
        $db = \app\core\Db::getInstance();        
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                JOIN genres ON songs.genre_id = genres.id 
                WHERE genres.genre = ?
                ORDER BY songs.id DESC";
        return $db->execQuery($sql, ['s', [$genreName]]);
    }

    
    public static function getGenres() {
        $db = \app\core\Db::getInstance();        
        return $db->execQuery("SELECT * FROM genres");
    }

   //CREATE 
    public static function createSong(array $data) {
        $db = \app\core\Db::getInstance();        
        $sql = 'INSERT INTO songs (title, artist, album, genre_id, year, cover_url) VALUES (?, ?, ?, ?, ?, ?)';
        $params = ['ssssss', [
            $data['title'] ?? null,
            $data['artist'] ?? null,
            $data['album'] ?? null,
            isset($data['genre_id']) && $data['genre_id'] !== '' ? $data['genre_id'] : null,
            $data['year'] ?? null,
            $data['cover_url'] ?? null
        ]];
        return $db->execQuery($sql, $params);
    }

    // UPDATE
    public static function updateSong(int $id, array $data) {
        $db = \app\core\Db::getInstance();        
        $sql = 'UPDATE songs SET title = ?, artist = ?, album = ?, genre_id = ?, year = ?, cover_url = ? WHERE id = ?';
        $params = ['ssssssi', [
            $data['title'] ?? null,
            $data['artist'] ?? null,
            $data['album'] ?? null,
            isset($data['genre_id']) && $data['genre_id'] !== '' ? $data['genre_id'] : null,
            $data['year'] ?? null,
            $data['cover_url'] ?? null,
            $id
        ]];
        return $db->execQuery($sql, $params);
    }

    // DELETE
    public static function deleteSong($id) {
        $db = \app\core\Db::getInstance();        
        $sql = 'DELETE FROM songs WHERE id = ?';
        return $db->execQuery($sql, ['i', [$id]]);
    }
}
?>