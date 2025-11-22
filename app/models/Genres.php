<?php
namespace app\models;
use app\core\Db;

class Genres {

  // Busca apenas a lista de nomes de géneros (para dropdowns)
  public static function getAllGenres() {
    $conn = new Db();
    $response = $conn->execQuery('SELECT id, genre FROM genres');
    return $response;
  }

  // NOVA FUNÇÃO: Busca músicas associadas a um género específico
  public static function getSongsByGenreName($genreName) {
    $conn = new Db();
    // Fazemos JOIN para garantir que filtramos pelo NOME do género (ex: 'House')
    $sql = "SELECT songs.*, genres.genre as genre_name 
            FROM songs 
            JOIN genres ON songs.genre_id = genres.id 
            WHERE genres.genre = ? 
            ORDER BY songs.id DESC";
            
    return $conn->execQuery($sql, ['s', [$genreName]]);
  }
}
?>