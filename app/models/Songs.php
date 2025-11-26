<?php
namespace app\models;
use app\core\Db;

class Songs {


    
    // --- FUNÇÃO NOVA: TOP 3 GÉNEROS ---
    public static function getTopGenres() {
        $db = new Db();
        // Conta quantas músicas existem por género, ordena decrescente e pega os 3 primeiros
        $sql = "SELECT genres.genre, COUNT(songs.id) as total 
                FROM songs 
                JOIN genres ON songs.genre_id = genres.id 
                GROUP BY genres.genre 
                ORDER BY total DESC 
                LIMIT 3";
        return $db->execQuery($sql);
    }

    // Buscar todas as músicas
    public static function getAllSongs() {
        $db = new Db();
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                LEFT JOIN genres ON songs.genre_id = genres.id 
                ORDER BY songs.id DESC";
        return $db->execQuery($sql);
    }

    // Buscar apenas músicas que têm álbum
    public static function getSongsWithAlbum() {
        $db = new Db();
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                LEFT JOIN genres ON songs.genre_id = genres.id 
                WHERE songs.album IS NOT NULL AND songs.album != ''
                ORDER BY songs.id DESC";
        return $db->execQuery($sql);
    }

    // Buscar músicas por nome do género
    public static function getSongsByGenreName($genreName) {
        $db = new Db();
        $sql = "SELECT songs.*, genres.genre as genre_name 
                FROM songs 
                JOIN genres ON songs.genre_id = genres.id 
                WHERE genres.genre = ?
                ORDER BY songs.id DESC";
        return $db->execQuery($sql, ['s', [$genreName]]);
    }

    // Buscar lista de géneros para o dropdown
    public static function getGenres() {
        $db = new Db();
        return $db->execQuery("SELECT * FROM genres");
    }

    // Criar Música
    public static function createSong(array $data) {
        $db = new Db();
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

    // Atualizar Música
    public static function updateSong(int $id, array $data) {
        $db = new Db();
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

    // Apagar Música
    public static function deleteSong($id) {
        $db = new Db();
        $sql = 'DELETE FROM songs WHERE id = ?';
        return $db->execQuery($sql, ['i', [$id]]);
    }
}
?>