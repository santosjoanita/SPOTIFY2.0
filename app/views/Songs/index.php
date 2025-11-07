<h1 class="text-center my-4">Random Songs</h1>

<?php if (!empty($data['songs'])): ?>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($data['songs'] as $song): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <!-- Se quiseres mostrar capa da música, podes adicionar uma imagem aqui -->
          <!-- <img src="<?= htmlspecialchars($song['cover_url'] ?? 'assets/img/TheBeatles.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($song['title']) ?>"> -->

          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($song['title']) ?></h5>
            <?php if (!empty($song['artist'])): ?>
              <p class="card-text"><strong>Artista:</strong> <?= htmlspecialchars($song['artist']) ?></p>
            <?php endif; ?>
            <?php if (!empty($song['album'])): ?>
              <p class="card-text"><strong>Álbum:</strong> <?= htmlspecialchars($song['album']) ?></p>
            <?php endif; ?>
            <?php if (!empty($song['genre'])): ?>
              <p class="card-text"><strong>Género:</strong> <?= htmlspecialchars($song['genre']) ?></p>
            <?php endif; ?>
            <?php if (!empty($song['year'])): ?>
              <p class="card-text"><strong>Ano:</strong> <?= htmlspecialchars($song['year']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-center mt-4">Não há músicas disponíveis.</p>
<?php endif; ?>
