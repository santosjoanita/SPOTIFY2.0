<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['genre'] ?? '3genre') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/genre.css">
</head>
<body>

    <div class="hero" style="background-image: url('<?= $url_alias ?>/assets/img/techno_concert.jpg');">
        <a href="<?= $url_alias ?>/" class="btn-home">← Home</a>
        <div class="hero-content">
            <h1><?= htmlspecialchars($data['genre'] ?? '3genre') ?></h1>
            <p>THE ULTIMATE MUSIC BROWSER</p>
        </div>
    </div>

    <div class="grid-container">
        <div class="grid">
            <?php if (!empty($data['items'])): ?>
                <?php foreach ($data['items'] as $item): ?>
                <div class="card">
                    <div class="card-img-wrapper">
                        <?php 
                             $cover = !empty($item['cover_url']) ? $item['cover_url'] : $url_alias . '/assets/img/records_albums.jpg';
                        ?>
                        <img src="<?= $cover ?>" alt="Capa">
                    </div>
                    <div class="card-title"><?= htmlspecialchars($item['title']) ?></div>
                    <div class="card-album"><?= !empty($item['album']) ? htmlspecialchars($item['album']) : 'Single' ?></div>
                    <div class="card-artist"><?= htmlspecialchars($item['artist']) ?></div>
                    <div class="card-meta"><?= htmlspecialchars($item['year']) ?></div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1;">Ainda não há músicas <?= htmlspecialchars($data['genre'] ?? '3genre') ?>.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
