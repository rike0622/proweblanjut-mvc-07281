<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventaris MVC</title>
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f1f5f9;
            --card: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .navbar {
            background: var(--card);
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .navbar-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .navbar-menu a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .navbar-menu a:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .btn-logout {
            background: var(--danger);
            color: white !important;
        }

        .btn-logout:hover {
            background: #dc2626 !important;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .welcome-card h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .content-card {
            background: var(--card);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .content-card h2 {
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .btn-primary {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-brand">📦 Inventaris MVC</div>
    <div class="navbar-menu">
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=products">Produk</a>
        <span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <a href="index.php?page=logout" class="btn-logout">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="welcome-card">
    <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>! 👋</h1>
        <p>Ini adalah dashboard sistem inventaris berbasis MVC</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Produk</h3>
            <div class="number">0</div>
        </div>
        <div class="stat-card">
            <h3>Stok Menipis</h3>
            <div class="number" style="color: var(--warning)">0</div>
        </div>
        <div class="stat-card">
            <h3>User Aktif</h3>
            <div class="number" style="color: var(--success)">1</div>
        </div>
    </div>

        <div class="content-card">
        <h2>Menu Cepat</h2>
        <a href="index.php?page=products" class="btn-primary">Kelola Produk</a>
        <p style="color: var(--text-muted); margin-top: 1rem;">
         Login sebagai: <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
        </p>
    </div>
</div>

</body>
</html>