<h1>Lista de músicas</h1>

<?php if (!empty($data['songs'])): ?>
  <ul>
    <?php foreach ($data['songs'] as $song): ?>
      <li>
        <strong><?= htmlspecialchars($song['title']) ?></strong>
        <?php if (!empty($song['artist'])): ?>
          — <?= htmlspecialchars($song['artist']) ?>
        <?php endif; ?>
        <?php if (!empty($song['album'])): ?>
          (<?= htmlspecialchars($song['album']) ?>)
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Não há músicas disponíveis.</p>
<?php endif; ?>
