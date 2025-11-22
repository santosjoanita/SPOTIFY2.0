<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Edit Song - Song Browser</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $url_alias ?>/assets/css/views_songs.css">
    <style>
        /* Ajuste para mostrar o formulário sempre nesta página */
        #form-container { display: block; margin-top: 50px; }
        body { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <a href="<?= $url_alias ?>/Songs" class="btn-home">← Back to List</a>

    <div class="hero" style="height: 200px; background-image: url('<?= $url_alias ?>/assets/img/cat_songs.jpg');">
        <div class="hero-content">
            <h1>Edit Song</h1>
        </div>
    </div>

    <div id="form-container">
        <?php $song = $data['song']; ?>
        
        <form action="<?= $url_alias ?>/Songs/update/<?= $song['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" value="<?= htmlspecialchars($song['title']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Artist *</label>
                <input type="text" name="artist" value="<?= htmlspecialchars($song['artist']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Change Cover (Optional)</label>
                <input type="file" name="cover_image" accept="image/*">
                <small style="color:#777;">Leave empty to keep current cover.</small>
            </div>

            <div class="form-group">
                <label>Genre</label>
                <select name="genre_id">
                    <option value="">-- Select --</option>
                    <?php if (!empty($data['genres'])): ?>
                        <?php foreach($data['genres'] as $g): ?>
                            <option value="<?= $g['id'] ?>" <?= ($song['genre_id'] == $g['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($g['genre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Album</label>
                <input type="text" name="album" value="<?= htmlspecialchars($song['album'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" value="<?= htmlspecialchars($song['year'] ?? '') ?>">
            </div>
            
            <button type="submit" class="btn btn-add" style="width:100%">Update Song</button>
            <br><br>
            <a href="<?= $url_alias ?>/Songs" style="display:block; text-align:center; color:#666; text-decoration:none;">Cancel</a>
        </form>
    </div>

</body>
</html>