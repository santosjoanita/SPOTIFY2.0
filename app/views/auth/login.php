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
</html>