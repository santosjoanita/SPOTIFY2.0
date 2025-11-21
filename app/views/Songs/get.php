<?php
// Show single song details
if (empty($data['song'])) {
    echo '<h3>Não existe essa música na base de dados.</h3>';
    echo '<a href="' . $url_alias . '/Songs">Voltar</a>';
    return;
}

$song = $data['song'];
$genres = $data['genres'] ?? [];
$genreLabel = '';
foreach ($genres as $g) { if (isset($song['genre_id']) && $g['id'] == $song['genre_id']) { $genreLabel = $g['genre']; break; } }
?>

<div class="card">
  <div class="card-body">
    <h4 class="card-title"><?= htmlspecialchars($song['title']) ?></h4>
    <p><strong>Artista:</strong> <?= htmlspecialchars($song['artist'] ?? '') ?></p>
    <p><strong>Álbum:</strong> <?= htmlspecialchars($song['album'] ?? '') ?></p>
    <p><strong>Ano:</strong> <?= htmlspecialchars($song['year'] ?? '') ?></p>
    <p><strong>Género:</strong> <?= htmlspecialchars($genreLabel) ?></p>
    <a href="<?= $url_alias ?>/Songs" class="btn btn-secondary">Voltar</a>
    <a href="<?= $url_alias ?>/Songs/edit/<?= htmlspecialchars($song['id']) ?>" class="btn btn-primary">Editar</a>
  </div>
</div>