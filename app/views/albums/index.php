<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Álbuns - Song</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Usamos o MESMO CSS das páginas de géneros -->
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/genre.css">
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/main.css">
</head>
<body>
    <?php require_once 'app/views/partials/header.php'; ?>

    <!-- HERO SECTION (Imagem de fundo dos álbuns) -->
    <div class="hero" style="background-image: url('<?= $url_alias ?>/assets/img/records_albums.jpg');">
        
        <!-- Botão Home -->
        <a href="<?= $url_alias ?>/" class="btn-home">← Home</a>

        <div class="hero-content">
            <h1>ÁLBUNS</h1>
            <p>THE ULTIMATE MUSIC BROWSER</p>
        </div>
    </div>

    <!-- GRELHA DE ÁLBUNS -->
    <div class="grid-container">
        <div class="grid">
            <?php if (!empty($data['albums'])): ?>
                <?php foreach ($data['albums'] as $album): ?>
                <div class="card">
                    <div class="card-img-wrapper">
                        <!-- Lógica da Imagem: Usa a capa da música ou a default -->
                        <?php 
                             $cover = !empty($album['cover_url']) ? $album['cover_url'] : $url_alias . '/assets/img/records_albums.jpg';
                        ?>
                        <img src="<?= $cover ?>" alt="Capa">
                    </div>
                    
                    <div class="card-title"><?= htmlspecialchars($album['title']) ?></div>
                    
                    <!-- Destaque para o nome do Álbum -->
                    <div class="card-album" style="color:#00C853; font-weight:500;">
                        <?= htmlspecialchars($album['album']) ?>
                    </div>
                    
                    <div class="card-artist"><?= htmlspecialchars($album['artist']) ?></div>
                    <div class="card-meta"><?= htmlspecialchars($album['year']) ?></div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1; color:#666;">
                    Ainda não há músicas com álbum registado.
                </p>
            <?php endif; ?>
        </div>
    </div>
<script src="<?= $url_alias ?>/assets/js/main.js"></script>
</body>
</html>