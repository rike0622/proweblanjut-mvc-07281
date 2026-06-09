<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventaris Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-light: #EEF2FF;
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
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

        .navbar { background: var(--card); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
        .brand { font-size: 1.25rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .nav-links { display: flex; gap: 1.5rem; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--text-light); font-weight: 500; font-size: 0.95rem; transition: 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        .user-pill { display: flex; align-items: center; gap: 0.75rem; padding: 0.4rem 0.8rem; background: var(--bg); border-radius: 99px; font-size: 0.9rem; }
        .btn-logout { background: var(--danger); color: white; padding: 0.4rem 0.9rem; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: 0.2s; }
        .btn-logout:hover { background: #dc2626; }
        
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }
        
        .welcome-card { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; position: relative; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2); }
        .welcome-card h1 { font-size: 1.8rem; margin-bottom: 0.5rem; }
        .welcome-card p { opacity: 0.95; font-size: 1.05rem; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: var(--card); padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .stat-info h3 { font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-weight: 600; }
        .stat-info .value { font-size: 1.75rem; font-weight: 700; color: var(--text); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .icon-blue { background: var(--primary-light); color: var(--primary); }
        .icon-red { background: #FEF2F2; color: var(--danger); }
        .icon-green { background: #ECFDF5; color: var(--success); }

        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 768px) { .content-grid { grid-template-columns: 1fr; } }

        .card-box { background: var(--card); border-radius: 12px; padding: 1.5rem; border: 1px solid var(--border); height: 100%; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
        .card-header h2 { font-size: 1.1rem; font-weight: 600; color: var(--text); }
        
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        th { text-align: left; font-size: 0.75rem; color: var(--text-light); padding: 0.75rem 1rem; border-bottom: 2px solid var(--border); text-transform: uppercase; font-weight: 600; }
        td { padding: 1rem; font-size: 0.95rem; border-bottom: 1px solid var(--border); color: var(--text); }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f9fafb; }
        
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .badge-ok { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .badge-warn { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }

        .action-btn { display: flex; align-items: center; gap: 1rem; width: 100%; padding: 1rem; border-radius: 10px; background: var(--bg); text-decoration: none; color: var(--text); transition: all 0.2s; margin-bottom: 0.75rem; border: 1px solid transparent; text-align: left; }
        .action-btn:hover { border-color: var(--primary); background: var(--primary-light); transform: translateX(4px); }
        .action-icon { width: 40px; height: 40px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex-shrink: 0; }
        .action-text strong { display: block; font-size: 0.95rem; margin-bottom: 2px; }
        .action-text span { font-size: 0.8rem; color: var(--text-light); }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-light); }
        .empty-state p { margin-top: 0.5rem; font-size: 0.9rem; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php?page=dashboard" class="brand">📦 Inventaris MVC</a>
    <div class="nav-links">
        <a href="index.php?page=dashboard" class="active">Dashboard</a>
        <a href="index.php?page=products">Produk</a>
        <div class="user-pill">
            <span>👤 <?= htmlspecialchars($user['name'] ?? 'User') ?></span>
            <a href="index.php?page=logout" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="welcome-card">
        <h1>Selamat Datang, <?= htmlspecialchars($user['name'] ?? 'Admin') ?>! 👋</h1>
        <p>Kelola data inventaris dan pantau stok barang Anda dengan mudah melalui panel ini.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Total Produk</h3>
                <div class="value"><?= isset($totalProducts) ? $totalProducts : 0 ?></div>
            </div>
            <div class="stat-icon icon-blue">📦</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Stok Menipis</h3>
                <div class="value" style="color:var(--warning)"><?= isset($lowStockCount) ? $lowStockCount : 0 ?></div>
            </div>
            <div class="stat-icon icon-red">⚠️</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>User Aktif</h3>
                <div class="value" style="color:var(--success)">1</div>
            </div>
            <div class="stat-icon icon-green">👤</div>
        </div>
    </div>

    <div class="content-grid">
        <div class="card-box">
            <div class="card-header">
                <h2>🕒 Produk Terbaru</h2>
                <a href="index.php?page=products" style="font-size:0.85rem; color:var(--primary); text-decoration:none; font-weight:500;">Lihat Semua &rarr;</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_products)): ?>
                            <?php foreach ($recent_products as $p): 
                                $statusClass = ($p['stok'] ?? 0) < 10 ? 'badge-warn' : 'badge-ok';
                                $statusText = ($p['stok'] ?? 0) < 10 ? 'Stok Rendah' : 'Tersedia';
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($p['nama_produk']) ?></strong></td>
                                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                <td><?= $p['stok'] ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= $statusText ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div style="font-size:2rem; margin-bottom:0.5rem;">📭</div>
                                        <p>Belum ada data produk.</p>
                                        <a href="index.php?page=products&action=create" style="color:var(--primary); text-decoration:none; font-weight:500; margin-top:0.5rem; display:inline-block;">+ Tambah Produk</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
<div class="card-box">
    <div class="card-header">
        <h2> Produk Best Seller</h2>
        <a href="index.php?page=products" style="font-size:0.85rem; color:var(--primary); text-decoration:none;">Lihat Semua →</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Terjual</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bestSellers)): ?>
                    <?php 
                    $rank = 1;
                    foreach ($bestSellers as $p): 
                        $badgeClass = $p['terjual'] > 100 ? 'badge-ok' : ($p['terjual'] > 50 ? 'badge-warn' : 'badge-warn');
                        $starCount = $p['terjual'] > 100 ? 5 : ($p['terjual'] > 50 ? 4 : 3);
                    ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-size: 1.2rem; font-weight: 700; color: var(--primary); width: 24px;">#<?= $rank++ ?></span>
                                <div>
                                    <div style="font-weight: 600;"><?= htmlspecialchars($p['nama_produk']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-light);">Stok: <?= $p['stok'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><strong>Rp <?= number_format($p['harga'], 0, ',', '.') ?></strong></td>
                        <td>
                            <span class="badge <?= $badgeClass ?>">
                                📦 <?= $p['terjual'] ?> terjual
                            </span>
                        </td>
                        <td>
                            <div style="color: var(--warning);">
                                <?= str_repeat('★', $starCount) ?>
                                <span style="color: var(--text-light);"><?= str_repeat('☆', 5 - $starCount) ?></span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div style="font-size:2rem; margin-bottom:0.5rem;">📊</div>
                                <p>Belum ada data penjualan.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
            
            <a href="index.php?page=products&action=create" class="action-btn">
                <div class="action-icon">➕</div>
                <div class="action-text">
                    <strong>Tambah Produk</strong>
                    <span>Input barang baru ke sistem</span>
                </div>
            </a>
            
            <a href="index.php?page=products" class="action-btn">
                <div class="action-icon">📝</div>
                <div class="action-text">
                    <strong>Kelola Stok</strong>
                    <span>Edit, update, atau hapus data</span>
                </div>
            </a>
            
            <a href="#" class="action-btn" onclick="alert('Fitur dokumentasi API akan segera hadir!')">
                <div class="action-icon">🔌</div>
                <div class="action-text">
                    <strong>Dokumentasi API</strong>
                    <span>Panduan integrasi REST API</span>
                </div>
            </a>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <h3 style="font-size:0.9rem; color:var(--text-light); margin-bottom:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">Info Sistem</h3>
                <div style="font-size:0.85rem; color:var(--text); line-height:1.6;">
                    <div>🗓️ Tanggal: <strong><?= date('d M Y') ?></strong></div>
                    <div>🕐 Jam: <strong><?= date('H:i') ?> WIB</strong></div>
                    <div>🌐 Server: <strong><?= $_SERVER['SERVER_NAME'] ?? 'Localhost' ?></strong></div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>