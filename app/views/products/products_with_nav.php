<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Inventaris MVC</title>
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
            text-decoration: none;
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

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .card {
            background: var(--card);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn-add {
            display: inline-block;
            background: var(--success);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background: var(--bg);
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-safe { background: #d1fae5; color: #065f46; }
        .badge-warn { background: #fef3c7; color: #92400e; }
        .badge-crit { background: #fee2e2; color: #991b1b; }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-edit { background: var(--warning); color: white; }
        .btn-del { background: var(--danger); color: white; margin-left: 0.5rem; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php?page=dashboard" class="navbar-brand">📦 Inventaris MVC</a>
    <div class="navbar-menu">
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=products">Produk</a>
        <span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <a href="index.php?page=logout" class="btn-logout">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="card">
        <h2 style="margin-bottom: 1rem;">Daftar Produk</h2>
        <a href="index.php?page=products&action=create" class="btn-add">+ Tambah Produk</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $p): 
                        $badgeClass = $p['stok'] < 10 ? 'badge-crit' : ($p['stok'] < 30 ? 'badge-warn' : 'badge-safe');
                    ?>
                    <tr>
                        <td>#<?= htmlspecialchars($p['id']) ?></td>
                        <td>
                            <?php if (!empty($p['gambar'])): ?>
                                <img src="../assets/uploads/<?= htmlspecialchars($p['gambar']) ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <span style="color: #999;">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['nama_produk']) ?></td>
                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= $p['stok'] ?></span></td>
                        <td>
                            <a href="index.php?page=products&action=edit&id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="index.php?page=products&action=delete&id=<?= $p['id'] ?>" 
                               class="btn btn-del" 
                               onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem;">Belum ada data produk</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>