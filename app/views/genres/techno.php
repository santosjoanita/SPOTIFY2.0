<?php // genres/techno view ?>
<style>
  .album-cover { width: 220px; height: 220px; object-fit: cover; margin: 0 auto 12px; display:block; border-radius:8px; }
  @media (max-width:768px){ .album-cover{ width:100%; height:auto; } }
</style>
<div class="genre-header" style="background-image: url('<?php echo $url_alias; ?>/assets/img/techno_concert.jpg'); padding: 60px 0; background-size: cover; background-position: center; color: white; text-align: center;">
  <h1 style="font-size:48px; margin:0;">TECNO</h1>
  <p style="letter-spacing:2px; margin-top:8px;">THE ULTIMATE MUSIC BROWSER</p>
</div>

<div class="container my-5">
  <?php if (!empty($data['items'])): ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <?php foreach ($data['items'] as $item): ?>
        <div class="col">
          <div class="card h-100 border-0">
            <img src="<?= htmlspecialchars($item['cover']) ?>" class="card-img-top album-cover" alt="<?= htmlspecialchars($item['title']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($item['artist']) ?></p>
              <p class="card-text"><?= htmlspecialchars($item['year']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Nenhum item encontrado.</p>
  <?php endif; ?>
</div>
