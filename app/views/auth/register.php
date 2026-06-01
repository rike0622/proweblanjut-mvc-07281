<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Inventaris MVC</title>
    <style>
        :root { --primary: #3b82f6; --bg: #f1f5f9; --card: #ffffff; --text: #0f172a; --text-muted: #64748b; --border: #e2e8f0; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .register-container { background: var(--card); padding: 2.5rem; border-radius: 16px; box-shadow: 0 20px 25px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .register-header { text-align: center; margin-bottom: 2rem; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text); }
        input { width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px; font-size: 1rem; }
        .btn-register { width: 100%; padding: 0.875rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 0.5rem; }
        .btn-register:hover { opacity: 0.9; }
        .login-link { text-align: center; margin-top: 1.5rem; color: var(--text-muted); }
        .login-link a { color: var(--primary); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-header">
        <h1>📝 Daftar Akun</h1>
        <p>Buat akun baru untuk mengakses sistem</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error">⚠️ <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success">✅ <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="index.php?page=register&action=process" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="name" placeholder="Pilih username" required autofocus>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="email@example.com" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn-register">Daftar</button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="index.php?page=login">Login di sini</a>
    </div>
</div>

</body>
</html>