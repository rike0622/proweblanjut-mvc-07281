<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - MVC</title>
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            --radius: 12px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background: var(--bg-color);
            color: var(--text-main);
            padding: 2rem 1rem;
            line-height: 1.5;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.75rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add { background: var(--success); color: #fff; }
        .btn-add:hover { background: #059669; transform: translateY(-1px); }

        .btn-edit { background: var(--warning); color: #fff; }
        .btn-edit:hover { background: #d97706; }

        .btn-del { background: var(--danger); color: #fff; }
        .btn-del:hover { background: #dc2626; }

        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 0.9rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        tbody tr { transition: background 0.15s ease; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        td img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border);
            display: block;
        }

        .actions { display: flex; gap: 0.5rem; }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-safe { background: #d1fae5; color: #065f46; }
        .badge-warn { background: #fef3c7; color: #92400e; }
        .badge-crit { background: #fee2e2; color: #991b1b; }

        .empty {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .container { padding: 1.25rem; }
            .header { flex-direction: column; align-items: flex-start; }
            th, td { padding: 0.75rem 0.6rem; font-size: 0.85rem; }
            td img { width: 48px; height: 48px; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2> Daftar Produk (MVC)</h2>
        <a href="index.php?action=create" class="btn btn-add">+ Tambah Produk</a>
    </div>

    <div class="table-wrapper">
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
                        <td style="font-weight:500; color:var(--text-muted);">#<?= htmlspecialchars($p['id']) ?></td>
                        <td>
                            <?php if (!empty($p['gambar'])): ?>
                                <img src="../assets/uploads/<?= htmlspecialchars($p['gambar']) ?>" alt="Produk">
                            <?php else: ?>
                                <div style="width:56px;height:56px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:11px;">No Img</div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:500;"><?= htmlspecialchars($p['nama_produk']) ?></td>
                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= $p['stok'] ?></span></td>
                        <td>
                            <div class="actions">
                                <a href="index.php?action=edit&id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="index.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-del" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="empty">Belum ada data produk. Silakan tambahkan data baru.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>