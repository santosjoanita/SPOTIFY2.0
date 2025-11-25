<?php
// Garantir que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<header class="site-header">
    <div class="auth-cta">
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a id="logout-button" href="<?= $url_alias ?>/Auth/logout" class="btn btn-outline-secondary">
                Logout (<?= htmlspecialchars($_SESSION['user_email'] ?? 'User') ?>)
            </a>
        <?php else: ?>
            <a id="login-button" href="<?= $url_alias ?>/Auth/login" class="btn btn-primary">
                Login
            </a>
        <?php endif; ?>
    </div>
</header>