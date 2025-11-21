<?php
if (empty($data['song'])) {
    echo '<h3>Música não encontrada.</h3>';
    echo '<a href="' . $url_alias . '/Songs">Voltar</a>';
    return;
}
$song = $data['song'];
?>

<h2>Editar Música</h2>
<form action="<?= $url_alias ?>/Songs/update/<?= htmlspecialchars($song['id']) ?>" method="POST" class="row gx-3 gy-2">
  <div class="col-md-6">
    <label for="title">Título:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($song['title']) ?>" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="artist">Artista:</label>
    <input type="text" id="artist" name="artist" value="<?= htmlspecialchars($song['artist'] ?? '') ?>" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label for="genre_id">Género:</label>
    <select id="genre_id" name="genre_id" class="form-select">
      <option value="">-- (sem género) --</option>
      <?php if (!empty($data['genres'])): foreach ($data['genres'] as $g): ?>
        <option value="<?= htmlspecialchars($g['id']) ?>" <?= (isset($song['genre_id']) && $song['genre_id'] == $g['id']) ? 'selected' : '' ?>><?= htmlspecialchars($g['genre']) ?></option>
      <?php endforeach; endif; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="album">Álbum:</label>
    <input type="text" id="album" name="album" value="<?= htmlspecialchars($song['album'] ?? '') ?>" class="form-control">
  </div>

  <div class="col-md-3">
    <label for="year">Ano:</label>
    <input type="number" id="year" name="year" value="<?= htmlspecialchars($song['year'] ?? '') ?>" class="form-control">
  </div>

  <!-- Cover URL removed from update form -->

  <div class="col-12 mt-2">
    <button type="submit" class="btn btn-primary">Atualizar Música</button>
    <a href="<?= $url_alias ?>/Songs" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
