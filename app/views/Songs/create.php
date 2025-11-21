<h2>Criar Nova Música</h2>

<form action="<?php echo $url_alias; ?>/Songs/store" method="POST" class="row gx-3 gy-2">
  <div class="col-6">
    <label for="title">Título:</label>
    <input type="text" id="title" name="title" class="form-control" required>
  </div>
  <div class="col-6">
    <label for="artist">Artista:</label>
    <input type="text" id="artist" name="artist" class="form-control" required>
  </div>
  <div class="col-6">
    <label for="genre_id">Género:</label>
    <select id="genre_id" name="genre_id" class="form-select">
      <option value="">-- (sem género) --</option>
      <?php if (!empty($data['genres'])): foreach ($data['genres'] as $genre): ?>
        <option value="<?= htmlspecialchars($genre['id']) ?>"><?= htmlspecialchars($genre['genre']) ?></option>
      <?php endforeach; endif; ?>
    </select>
  </div>
  <div class="col-6">
    <label for="album">Álbum:</label>
    <input type="text" id="album" name="album" class="form-control">
  </div>
  <div class="col-3">
    <label for="year">Ano:</label>
    <input type="number" id="year" name="year" class="form-control">
  </div>
  <!-- Cover URL removed from create form -->
  <div class="col-12 mt-2">
    <button type="submit" class="btn btn-primary">Criar Música</button>
    <a href="<?php echo $url_alias; ?>/Songs" class="btn btn-secondary">Voltar</a>
  </div>
</form>


