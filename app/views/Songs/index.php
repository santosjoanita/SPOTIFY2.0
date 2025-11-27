<?php
// Verificar sessão e permissões
if(!isset($_SESSION)) { session_start(); }

// Se não estiver com sessão iniciada, manda para o Login
if (!isset($_SESSION['user_id'])) {
    header('Location: /pw/tab1_pw/SPOTIFY2.0/Auth/login');
    exit;
}

//  controla se mostramos os botões ou não
$isAdmin = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Song - Ultimate Music Browser</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/main.css">
    
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/views_songs.css">
</head>
<body>
    
    <?php require_once 'app/views/partials/header.php'; ?>

    <a href="<?= $url_alias ?>/" class="btn-home">← Home</a>

    <div class="hero" style="background-image: url('<?= $url_alias ?>/assets/img/cat_songs.jpg');">
        <div class="hero-content">
            <h1>All Songs</h1>
            <p>THE ULTIMATE MUSIC BROWSER</p>
        </div>
    </div>

    <?php if ($isAdmin): ?>
        <div class="actions">
            <button onclick="toggleForm()" class="btn btn-add">Add Music</button>
            <button onclick="toggleDeleteMode()" class="btn btn-remove" id="btnRemove">Remove Music</button>
        </div>

        <div id="form-container">
            <h3 style="margin-top:0">New Song</h3>
            <form action="<?= $url_alias ?>/Songs/store" method="POST" enctype="multipart/form-data">
                <div class="form-group"><label>Title *</label><input type="text" name="title" required></div>
                <div class="form-group"><label>Artist *</label><input type="text" name="artist" required></div>
                <div class="form-group"><label>Cover</label><input type="file" name="cover_image" accept="image/*"></div>
                <div class="form-group"><label>Genre</label>
                    <select name="genre_id"><option value="">-- Select --</option>
                        <?php if (!empty($data['genres'])): foreach($data['genres'] as $g): ?>
                        <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['genre']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="form-group"><label>Album</label><input type="text" name="album"></div>
                <div class="form-group"><label>Year</label><input type="number" name="year"></div>
                <button type="submit" class="btn btn-add" style="width:100%">Save</button>
            </form>
        </div>
    <?php endif; ?>
    <!-- Aqui começa o filtro por géneros-->
<div class="filter-container" style="display:flex; justify-content:center; margin: 30px 0;">
        <select id="genreFilter" class="genre-select" style="padding:10px 20px; border-radius:30px; border:1px solid #ccc; min-width:250px;">
            <option value="all">Todos os Géneros</option>
            <?php if (!empty($data['genres'])): ?>
                <?php foreach($data['genres'] as $g): ?>
                    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['genre']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="grid-container">
        <?php if(isset($data['title']) && $data['title'] != 'All Songs'): ?>
            <h2 style="text-align:center; text-transform:uppercase; color:#888;">
                <?= htmlspecialchars($data['title']) ?>
            </h2>
        <?php endif; ?>

        <div class="grid">
    <?php if(empty($data['songs'])): ?>
        <p style="text-align:center; width:100%; grid-column: 1/-1;">No songs yet.</p>
    <?php else: ?>
        <?php foreach($data['songs'] as $song): ?>
       
        <div class="card song-card" data-genre-id="<?= $song['genre_id'] ?>">   <!-- tem de ter o genre id para o filtro funcionar. -->
            <div class="card-img-wrapper">
                <?php if ($isAdmin): ?>
                    <a href="<?= $url_alias ?>/Songs/delete/<?= $song['id'] ?>" 
                       class="delete-overlay" 
                       onclick="return confirm('Delete song?')">X</a>
                    
                    <a href="<?= $url_alias ?>/Songs/edit/<?= $song['id'] ?>" 
                       class="edit-overlay">✏️</a>
                <?php endif; ?>

                <?php $capa = !empty($song['cover_url']) ? $song['cover_url'] : $url_alias . '/assets/img/records_albums.jpg'; ?>
                <img src="<?= $capa ?>" alt="Capa">
            </div>
            <!-- Aqui vai buscar os detalhes de cada música para meter no card -->
            <div class="card-title"><?= htmlspecialchars($song['title']) ?></div>
            <div class="card-album"><?= !empty($song['album']) ? htmlspecialchars($song['album']) : 'Single' ?></div>
            <div class="card-artist"><?= htmlspecialchars($song['artist']) ?></div>
            <div class="card-meta">
                <?php 
                    $gName = $song['genre_name'] ?? '';
                    if (!$gName && !empty($data['genres'])) {
                        foreach($data['genres'] as $g) { if($g['id'] == $song['genre_id']) { $gName = $g['genre']; break; }}
                    }
                ?>
                <?= $gName ?> <?= !empty($song['year']) ? ' • ' . $song['year'] : '' ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


    <script src="<?= $url_alias ?>/assets/js/views_songs.js"></script>
    <script src="<?= $url_alias ?>/assets/js/main.js"></script>
</body>
</html>