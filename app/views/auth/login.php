<<<<<<< HEAD
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
=======
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Song App</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background: #333; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; color: #333; padding: 40px; border-radius: 10px; width: 300px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #00C853; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        button:hover { background: #009624; }
        .error { color: red; font-size: 0.9rem; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2 style="margin-top:0">Login</h2>
        
        <?php if(isset($_GET['error'])): ?>
            <p class="error">Email ou password incorretos.</p>
        <?php endif; ?>

        <form action="/pw/tab1_pw/SPOTIFY2.0/Auth/check" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Entrar</button>
        </form>
        
        <p style="font-size:0.8rem; margin-top:20px; color:#666;">
            Admin: user@admin.ipvc.pt (admin1234)<br>
            Guest: user@convidado.ipvc.pt (convidado1234)
        </p>
    </div>

</body>
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
</html>