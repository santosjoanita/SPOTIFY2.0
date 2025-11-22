<?php
// 1. Verificar sessão e permissões
if(!isset($_SESSION)) { session_start(); }

// Se não estiver logado, manda para o Login
if (!isset($_SESSION['user_id'])) {
    header('Location: /pw/tab1_pw/SPOTIFY2.0/Auth/login');
    exit;
}

// Variável que controla se mostramos os botões ou não
$isAdmin = ($_SESSION['user_role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Song - Ultimate Music Browser</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/views_songs.css">
</head>
<body>
    <div style="position:absolute; top:20px; right:20px; z-index:100; display:flex; gap:15px; align-items:center;">
        <span style="color:white; text-shadow:0 1px 2px rgba(0,0,0,0.8); font-weight:bold;">
            <?= htmlspecialchars($_SESSION['user_email']) ?> (<?= $_SESSION['user_role'] ?>)
        </span>
        <a href="<?= $url_alias ?>/Auth/logout" style="background:rgba(0,0,0,0.5); color:white; padding:5px 15px; text-decoration:none; border-radius:15px; font-size:0.8rem; border:1px solid white;">Sair</a>
    </div>

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
                <div class="card">
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
                    
                    <div class="card-title"><?= htmlspecialchars($song['title']) ?></div>
                    <div class="card-album"><?= !empty($song['album']) ? htmlspecialchars($song['album']) : 'Single' ?></div>
                    <div class="card-artist"><?= htmlspecialchars($song['artist']) ?></div>
                    <div class="card-meta">
                        <?= isset($song['genre_name']) ? $song['genre_name'] : '' ?> 
                        <?= !empty($song['year']) ? ' • ' . $song['year'] : '' ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?= $url_alias ?>/assets/js/views_songs.js"></script>
</body>
</html>