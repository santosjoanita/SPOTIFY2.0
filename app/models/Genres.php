<?php
namespace app\models;
use app\core\Db;

class Genres {

  //vai buscar a lista dos géneros para o dropdown
  public static function getAllGenres() {
    $conn = \app\core\Db::getInstance();
    $response = $conn->execQuery('SELECT id, genre FROM genres');
    return $response;
  }

  // apenas as músicas associadas a um género específico
  public static function getSongsByGenreName($genreName) {
    $conn = \app\core\Db::getInstance();
    // garante que filtra-se o nome pelo género
    $sql = "SELECT songs.*, genres.genre as genre_name 
            FROM songs 
            JOIN genres ON songs.genre_id = genres.id 
            WHERE genres.genre = ? 
            ORDER BY songs.id DESC";
            
    return $conn->execQuery($sql, ['s', [$genreName]]);
  }
}
?>