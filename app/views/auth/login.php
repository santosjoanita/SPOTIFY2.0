<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Song App</title>
    <link rel="stylesheet" href="<?= $url_alias; ?>/assets/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $url_alias; ?>/assets/css/main.css">
    <style>
      body { background-color: #f5f5f5; }
      .login-container { min-height: 100vh; display:flex; align-items:center; justify-content:center; }
      .card { width: 100%; max-width: 400px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    </style>
  </head>
  <body>
    
    <div class="login-container">
      <div class="card">
        <div class="card-body p-4">
          <h4 class="card-title mb-4 text-center fw-bold">Login</h4>
          
          <?php if (!empty($data['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
          <?php endif; ?>

          <form action="<?= $url_alias ?>/Auth/login" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="nome@exemplo.com">
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </div>
          </form>
          
          <hr class="my-4">
          <div class="text-muted small text-center">
            <p class="mb-1"><strong>Admin:</strong> user@admin.ipvc.pt (admin1234)</p>
            <p><strong>Guest:</strong> user@convidado.ipvc.pt (convidado1234)</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>