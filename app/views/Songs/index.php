<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Song - Ultimate Music Browser</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/views_songs.css">
</head>
<body>
<a href="<?= $url_alias ?>/" class="btn-home">← Home</a>
    <!-- Estilo inline apenas para a imagem de fundo funcionar com o caminho dinâmico -->
    <div class="hero" style="background-image: url('<?= $url_alias ?>/assets/img/cat_songs.jpg');">
        <div class="hero-content">
            <h1>All Songs</h1>
            <p>THE ULTIMATE MUSIC BROWSER</p>
        </div>
    </div>

    <!-- 2. BOTÕES -->
    <div class="actions">
        <button onclick="toggleForm()" class="btn btn-add">Add Music</button>
        <button onclick="toggleDeleteMode()" class="btn btn-remove" id="btnRemove">Remove Music</button>
    </div>
    
  

    <!-- 3. FORMULÁRIO (COM UPLOAD) -->
    <div id="form-container">
        <h3 style="margin-top:0">New Song</h3>
        <!-- enctype="multipart/form-data" é OBRIGATÓRIO para enviar imagens -->
        <form action="<?= $url_alias ?>/Songs/store" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" required placeholder="Ex: Thriller">
            </div>
            
            <div class="form-group">
                <label>Artist *</label>
                <input type="text" name="artist" required placeholder="Ex: Michael Jackson">
            </div>
            
            <!-- CAMPO DE IMAGEM -->
            <div class="form-group">
                <label>Cover (Opcional)</label>
                <input type="file" name="cover_image" accept="image/*">
            </div>

            <div class="form-group">
                <label>Genre</label>
                <select name="genre_id">
                    <option value="">-- Select --</option>
                    <?php if (!empty($data['genres'])): ?>
                        <?php foreach($data['genres'] as $g): ?>
                            <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['genre']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Album</label>
                <input type="text" name="album" placeholder="Album name">
            </div>
            
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" placeholder="Ex: 1982">
            </div>
            
            <button type="submit" class="btn btn-add" style="width:100%">Save</button>
        </form>
    </div>

    <!-- 4. LISTAGEM DE MÚSICAS -->
    <div class="grid-container">
        <?php if(isset($data['title']) && $data['title'] != 'All Songs'): ?>
            <h2 style="text-align:center; text-transform:uppercase; color:#888;">
                <?= htmlspecialchars($data['title']) ?>
            </h2>
        <?php endif; ?>

        <div class="grid">
            <?php if(empty($data['songs'])): ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1;">No songs yeat. Add some!</p>
            <?php else: ?>
                <?php foreach($data['songs'] as $song): ?>
                <div class="card">
                    <div class="card-img-wrapper">
                        <!-- Botão X -->
                        <a href="<?= $url_alias ?>/Songs/delete/<?= $song['id'] ?>" 
                           class="delete-overlay" 
                           onclick="return confirm('Are you sure you want to delete this song?')">X</a>
                        
                        <!-- IMAGEM DA CAPA -->
                        <?php 
                            // Se existir link na BD usa esse, senão usa o default
                            $capa = !empty($song['cover_url']) ? $song['cover_url'] : $url_alias . '/assets/img/records_albums.jpg';
                        ?>
                        <img src="<?= $capa ?>" alt="Capa">
                    </div>
                    
                    <div class="card-title"><?= htmlspecialchars($song['title']) ?></div>
                    <div class="card-album"><?= !empty($song['album']) ? htmlspecialchars($song['album']) : 'Single' ?></div>
                    <div class="card-artist"><?= htmlspecialchars($song['artist']) ?></div>
                    
                    <?php 
                        $genreName = isset($song['genre_name']) ? $song['genre_name'] : '';
                        // Fallback se vier apenas o ID e não o nome (depende do método do model usado)
                        if (empty($genreName) && !empty($data['genres'])) {
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

    <!-- JS Externo -->
    <script src="<?= $url_alias ?>/assets/js/views_songs.js"></script>
</body>
</html>