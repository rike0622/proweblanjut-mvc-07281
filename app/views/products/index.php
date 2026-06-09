<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Inventaris MVC</title>
    <style>
        :root {
            --primary: #4F46E5;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg: #F3F4F6;
            --card: #FFFFFF;
            --text: #1F2937;
            --text-light: #6B7280;
            --border: #E5E7EB;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); }

        .navbar { background: var(--card); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); }
        .brand { font-size: 1.25rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--text-light); font-weight: 500; }
        .nav-links a:hover { color: var(--primary); }
        .btn-logout { background: var(--danger); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 0.85rem; }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }
        .card { background: var(--card); padding: 2rem; border-radius: 12px; border: 1px solid var(--border); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .header h2 { font-size: 1.5rem; font-weight: 700; }
        .btn-add { background: var(--success); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .btn-add:hover { opacity: 0.9; }

        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1rem; background: var(--bg); font-size: 0.8rem; color: var(--text-light); text-transform: uppercase; border-bottom: 2px solid var(--border); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); }
        tr:hover { background: #f9fafb; }

        img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-ok { background: #ECFDF5; color: #065F46; }
        .badge-warn { background: #FEF3C7; color: #92400E; }

        .btn { padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-block; }
        .btn-edit { background: var(--warning); color: white; }
        .btn-del { background: var(--danger); color: white; margin-left: 0.5rem; }

        .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-success { background: #D1FAE5; color: #065F46; }
        .alert-error { background: #FEE2E2; color: #991B1B; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php?page=dashboard" class="brand">📦 Inventaris MVC</a>
    <div class="nav-links">
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=products" style="color: var(--primary);">Produk</a>
        <span>👤 <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
        <a href="index.php?page=logout" class="btn-logout">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="card">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="header">
            <h2>📦 Daftar Produk</h2>
            <a href="index.php?page=products&action=create" class="btn-add">+ Tambah Produk</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $p): 
                            $statusClass = ($p['stok'] ?? 0) < 10 ? 'badge-warn' : 'badge-ok';
                            $statusText = ($p['stok'] ?? 0) < 10 ? 'Stok Rendah' : 'Tersedia';
                        ?>
                        <tr>
                            <td>#<?= htmlspecialchars($p['id']) ?></td>
                            <td>
                                <?php if (!empty($p['gambar'])): ?>
                                    <img src="../assets/uploads/<?= htmlspecialchars($p['gambar']) ?>" alt="Produk">
                                <?php else: ?>
                                    <div style="width:50px;height:50px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:11px;">No Img</div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= htmlspecialchars($p['nama_produk']) ?></strong></td>
                            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                            <td><?= $p['stok'] ?></td>
                            <td><?= $p['terjual'] ?? 0 ?></td>
                            <td><span class="badge <?= $statusClass ?>"><?= $statusText ?></span></td>
                            <td>
                                <a href="index.php?page=products&action=edit&id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="index.php?page=products&action=delete&id=<?= $p['id'] ?>" class="btn btn-del" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-light);">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                                <p>Belum ada data produk.</p>
                                <a href="index.php?page=products&action=create" style="color: var(--primary); text-decoration: none; font-weight: 600; margin-top: 1rem; display: inline-block;">+ Tambah Produk Pertama</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>