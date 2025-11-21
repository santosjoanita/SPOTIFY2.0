<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Song - Ultimate Music Browser</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/views_songs.css">
</head>
<body>

    <div class="hero" style="background-image: url('<?= $url_alias ?>/assets/img/cat_songs.jpg');">
        <div class="hero-content">
            <h1>Song</h1>
            <p>THE ULTIMATE MUSIC BROWSER</p>
        </div>
    </div>

    <div class="actions">
        <button onclick="toggleForm()" class="btn btn-add">Adicionar música</button>
        <button onclick="toggleDeleteMode()" class="btn btn-remove" id="btnRemove">Remover Música</button>
    </div>

    <div id="form-container">
        <h3 style="margin-top:0">Nova Música</h3>
        <form action="<?= $url_alias ?>/Songs/store" method="POST">
            <div class="form-group">
                <label>Título *</label>
                <input type="text" name="title" required placeholder="Ex: Thriller">
            </div>
            <div class="form-group">
                <label>Artista *</label>
                <input type="text" name="artist" required placeholder="Ex: Michael Jackson">
            </div>
            <div class="form-group">
                <label>Género</label>
                <select name="genre_id">
                    <option value="">-- Selecionar --</option>
                    <?php if (!empty($data['genres'])): ?>
                        <?php foreach($data['genres'] as $g): ?>
                            <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['genre']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Álbum</label>
                <input type="text" name="album" placeholder="Nome do álbum">
            </div>
            <div class="form-group">
                <label>Ano</label>
                <input type="number" name="year" placeholder="Ex: 1982">
            </div>
            <button type="submit" class="btn btn-add" style="width:100%">Guardar</button>
        </form>
    </div>

    <div class="grid-container">
        <?php if(isset($data['title']) && $data['title'] != 'All Songs'): ?>
            <h2 style="text-align:center; text-transform:uppercase; color:#888;">
                <?= htmlspecialchars($data['title']) ?>
            </h2>
        <?php endif; ?>

        <div class="grid">
            <?php if(empty($data['songs'])): ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1;">Ainda não há músicas.</p>
            <?php else: ?>
                <?php foreach($data['songs'] as $song): ?>
                <div class="card">
                    <div class="card-img-wrapper">
                        <a href="<?= $url_alias ?>/Songs/delete/<?= $song['id'] ?>" 
                           class="delete-overlay" 
                           onclick="return confirm('Tem a certeza que quer eliminar esta música?')">X</a>
                        
                        <img src="<?= $url_alias ?>/assets/img/records_albums.jpg" alt="Capa">
                    </div>
                    
                    <div class="card-title"><?= htmlspecialchars($song['title']) ?></div>
                    <div class="card-album"><?= !empty($song['album']) ? htmlspecialchars($song['album']) : 'Single' ?></div>
                    <div class="card-artist"><?= htmlspecialchars($song['artist']) ?></div>
                    
                    <?php 
                        $genreName = '';
                        if (!empty($data['genres'])) {
                            foreach($data['genres'] as $g) {
                                if($g['id'] == $song['genre_id']) { $genreName = $g['genre']; break; }
                            }
                        }
                    ?>
                    <div class="card-meta">
                        <?= $genreName ?> <?= !empty($song['year']) ? ' • ' . $song['year'] : '' ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?= $url_alias ?>/assets/js/views_songs.js"></script>
</body>
</html>