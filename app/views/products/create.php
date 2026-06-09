<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; padding: 2rem; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 1.5rem; color: #333; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #555; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
        input:focus { outline: none; border-color: #4F46E5; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; width: 100%; }
        .btn-primary { background: #4F46E5; color: white; }
        .btn-primary:hover { background: #4338CA; }
        .btn-secondary { background: #e5e7eb; color: #374151; margin-top: 0.75rem; text-align: center; display: block; text-decoration: none; }
        .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
<div class="container">
    <h2>➕ Tambah Produk Baru</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form action="index.php?page=products&action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_produk">Nama Produk *</label>
            <input type="text" id="nama_produk" name="nama_produk" required placeholder="Masukkan nama produk">
        </div>
        
        <div class="form-group">
            <label for="harga">Harga (Rp) *</label>
            <input type="number" id="harga" name="harga" required min="0" placeholder="Contoh: 5000">
        </div>
        
        <div class="form-group">
            <label for="stok">Stok *</label>
            <input type="number" id="stok" name="stok" required min="0" placeholder="Contoh: 100">
        </div>
        
        <div class="form-group">
            <label for="gambar">Gambar Produk (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
        </div>

        <div class="form-group">
            <label for="terjual">Jumlah Terjual</label>
            <input type="number" id="terjual" name="terjual" value="0" min="0">
        </div>
        
        <button type="submit" class="btn btn-primary">💾 Simpan Produk</button>
        <a href="index.php?page=products" class="btn btn-secondary">← Kembali</a>
    </form>
</div>
</body>
</html>