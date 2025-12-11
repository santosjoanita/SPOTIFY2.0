<?php
use app\models\Songs;

// Vai buscar os géneros com mais músicas
$topGenres = Songs::getTopGenres();

// Fallback caso a BD esteja vazia
$g1 = $topGenres[0] ?? ['genre' => 'Old School'];
$g2 = $topGenres[1] ?? ['genre' => 'House'];
$g3 = $topGenres[2] ?? ['genre' => 'Techno'];

function getGenreImage($genreName, $alias) {
    $name = strtolower($genreName);
    if (strpos($name, 'old') !== false) return $alias . '/assets/img/car_oldschool.jpg';
    if (strpos($name, 'house') !== false) return $alias . '/assets/img/boots_house.jpg';
    if (strpos($name, 'tech') !== false) return $alias . '/assets/img/techno_concert.jpg';
    return $alias . '/assets/img/records_albums.jpg';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo $url_alias; ?>/assets/css/home.index.css">
    
    <?php require_once 'app/views/partials/header.php'; ?>

    <title>Melo Music</title>
  </head>
  <body>

<div class="main-container">
  
  <div class="header-title">
      <h1>Melo Music</h1>
      <h3>THE ULTIMATE MUSIC BROWSER</h3>
  </div>

  <div class="home-grid">
      
      <div class="grid-item big">
          <img src="<?php echo $url_alias; ?>/assets/img/cat_songs.jpg" alt="Cat Songs">
          <a href="<?php echo $url_alias;?>/Songs" class="card-btn">SONGS</a>
      </div>

      <div class="grid-item big">
          <img src="<?php echo getGenreImage($g1['genre'], $url_alias); ?>" alt="<?php echo $g1['genre']; ?>">
          <a href="<?php echo $url_alias;?>/Genres/1genre/<?php echo urlencode($g1['genre']); ?>" class="card-btn text-uppercase">
              <?php echo $g1['genre']; ?>
          </a>
      </div>

      <div class="grid-item small">
          <img src="<?php echo getGenreImage($g2['genre'], $url_alias); ?>" alt="<?php echo $g2['genre']; ?>">
          <a href="<?php echo $url_alias;?>/Genres/2genre/<?php echo urlencode($g2['genre']); ?>" class="card-btn text-uppercase">
              <?php echo $g2['genre']; ?>
          </a>
      </div>

      <div class="grid-item small">
          <img src="<?php echo getGenreImage($g3['genre'], $url_alias); ?>" alt="<?php echo $g3['genre']; ?>">
          <a href="<?php echo $url_alias;?>/Genres/3genre/<?php echo urlencode($g3['genre']); ?>" class="card-btn text-uppercase">
              <?php echo $g3['genre']; ?>
          </a>
      </div>

      <div class="grid-item small">
          <img src="<?php echo $url_alias; ?>/assets/img/records_albums.jpg" alt="Albums">
          <a href="<?php echo $url_alias;?>/Albums" class="card-btn">ALBUMS</a>
      </div>

  </div>
</div>

  
<div class="authors-section">
    <h2>AUTORAS</h2>
    
    <div class="authors-list">
        <div class="author-item">
            <img src="<?= $url_alias ?>/assets/img/joana.jpeg" alt="Joana Martins">
            <p>Joana Martins | 31365</p>
        </div>

        <div class="author-item">
            <img src="<?= $url_alias ?>/assets/img/sofia.jpeg" alt="Sofia Martins">
            <p>Sofia Martins | 28849</p>
        </div>
    </div>
</div>

<script src="<?= $url_alias ?>/assets/js/main.js"></script>
</body>
</html>