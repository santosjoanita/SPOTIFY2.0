<?php
// Carregar o Model Songs para buscar o Top 3
use app\models\Songs;

// Busca os Top 3 Géneros
$topGenres = Songs::getTopGenres();

// Define valores padrão (fallback) caso a BD esteja vazia
$g1 = $topGenres[0] ?? ['genre' => 'Old School'];
$g2 = $topGenres[1] ?? ['genre' => 'House'];
$g3 = $topGenres[2] ?? ['genre' => 'Techno'];

// Função auxiliar simples para escolher a imagem baseada no nome
function getGenreImage($genreName, $alias) {
    $name = strtolower($genreName);
    if (strpos($name, 'old') !== false) return $alias . '/assets/img/car_oldschool.jpg';
    if (strpos($name, 'house') !== false) return $alias . '/assets/img/boots_house.jpg';
    if (strpos($name, 'tech') !== false) return $alias . '/assets/img/techno_concert.jpg';
    // Imagem genérica para géneros novos (Pop, Rock, etc)
    return $alias . '/assets/img/records_albums.jpg';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="<?php echo $url_alias; ?>/assets/css/home.index.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo $url_alias; ?>/assets/css/home.index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Melo</title>
  </head>
  <body>
<div class="container">
  <h1>Melo Music</h1>
  <h3>THE ULTIMATE MUSIC BROWSER</h3>

 <div class="container home-content">
  <div class="row gx-4 gy-4">
    
    <!-- CARD 1: SONGS (Fixo) -->
    <div class="col-md-6">
      <div class="card-container">
        <img src="<?php echo $url_alias; ?>/assets/img/cat_songs.jpg" class="card-image big" alt="Cat Songs">
        <a href="<?php echo $url_alias;?>/Songs" class="card-link">SONGS</a>
      </div>
    </div>

        <!-- CARD 2: TOP GÉNERO #1 (Dinâmico) -->
    <div class="col-md-6">
      <div class="card-container">
        <!-- Usa a imagem baseada no nome do género -->
        <img src="<?php echo getGenreImage($g1['genre'], $url_alias); ?>" class="card-image big" alt="<?php echo $g1['genre']; ?>">
        <!-- Link dinâmico para o controller (inclui o nome do género) -->
        <a href="<?php echo $url_alias;?>/Genres/1genre/<?php echo urlencode($g1['genre']); ?>" class="card-link text-uppercase">
          <?php echo $g1['genre']; ?>
        </a>
      </div>
    </div>

    <!-- CARD 3: TOP GÉNERO #2 (Dinâmico) -->
    <div class="col-md-4">
      <div class="card-container">
        <img src="<?php echo getGenreImage($g2['genre'], $url_alias); ?>" class="card-image small" alt="<?php echo $g2['genre']; ?>">
        <a href="<?php echo $url_alias;?>/Genres/2genre/<?php echo urlencode($g2['genre']); ?>" class="card-link text-uppercase">
          <?php echo $g2['genre']; ?>
        </a>
      </div>
    </div>

    <!-- CARD 4: TOP GÉNERO #3 (Dinâmico) -->
    <div class="col-md-4">
      <div class="card-container">
        <img src="<?php echo getGenreImage($g3['genre'], $url_alias); ?>" class="card-image small" alt="<?php echo $g3['genre']; ?>">
        <a href="<?php echo $url_alias;?>/Genres/3genre/<?php echo urlencode($g3['genre']); ?>" class="card-link text-uppercase">
          <?php echo $g3['genre']; ?>
        </a>
      </div>
    </div>

    <!-- CARD 5: ÁLBUNS (Fixo) -->
    <div class="col-md-4">
      <div class="card-container">
        <img src="<?php echo $url_alias; ?>/assets/img/records_albums.jpg" class="card-image small" alt="Albums">
        <a href="<?php echo $url_alias;?>/Albums" class="card-link">ALBUMS</a>
      </div>
    </div>
  </div>
</div>

<<<<<<< HEAD
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
  </body>
</html>