<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Inventaris MVC</title>
    <style>
        :root { --primary: #4F46E5; --warning: #F59E0B; --bg: #F3F4F6; --card: #FFFFFF; --text: #1F2937; --text-light: #6B7280; --border: #E5E7EB; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .container { background: var(--card); padding: 2.5rem; border-radius: 12px; border: 1px solid var(--border); width: 100%; max-width: 600px; }
        h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
        input { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 8px; font-size: 1rem; }
        input:focus { outline: none; border-color: var(--primary); }
        .btn-group { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn { flex: 1; padding: 0.85rem; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--warning); color: white; }
        .btn-secondary { background: #E5E7EB; color: var(--text); }
        .alert-error { background: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .current-file { margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-light); background: var(--bg); padding: 0.5rem; border-radius: 6px; }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Edit Produk</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="index.php?page=products&action=update&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_produk">Nama Produk *</label>
            <input type="text" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp) *</label>
            <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($product['harga']) ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="stok">Stok *</label>
            <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($product['stok']) ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="terjual">Jumlah Terjual</label>
            <input type="number" id="terjual" name="terjual" value="<?= htmlspecialchars($product['terjual'] ?? 0) ?>" min="0">
        </div>

        <div class="form-group">
            <label for="gambar">Ganti Gambar (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            <?php if (!empty($product['gambar'])): ?>
                <div class="current-file">📁 Gambar saat ini: <?= basename($product['gambar']) ?></div>
            <?php endif; ?>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">🔄 Update Produk</button>
            <a href="index.php?page=products" class="btn btn-secondary">← Batal</a>
        </div>
    </form>
</div>

</body>
</html>