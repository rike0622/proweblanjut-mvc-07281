<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - MVC</title>
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --warning: #f59e0b; 
            --warning-hover: #d97706;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .form-container {
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 600px;
        }

        .form-header { margin-bottom: 2rem; 
            text-align: center; }

        .form-header h2 { font-size: 1.75rem; 
            font-weight: 700; 
            margin-bottom: 0.5rem; }

        .form-header p { color: var(--text-muted); 
            font-size: 0.95rem; }

        .form-group { margin-bottom: 1.5rem; }

        label { display: block; 
            margin-bottom: 0.5rem; 
            font-weight: 600; 
            font-size: 0.9rem; }

        input[type="text"], 
        input[type="number"], 
        input[type="file"] {
            width: 100%; 
            padding: 0.85rem 1rem; 
            border: 1px solid var(--border);
            border-radius: 8px; 
            font-size: 1rem; 
            background: #f8fafc;
            transition: all 0.2s ease; 
            color: var(--text-main);
        }

        input[type="text"]:focus, 
        input[type="number"]:focus {
            outline: none; 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #fff;
        }

        input[type="file"] { padding: 0.6rem; 
            background: #fff; 
            cursor: pointer; }

        .current-file {
            margin-top: 0.5rem; 
            font-size: 0.85rem; 
            color: var(--text-muted);
            background: #f8fafc; 
            padding: 0.5rem; 
            border-radius: 6px;
            display: inline-block; 
            border: 1px dashed var(--border);
        }

        .btn-group { display: flex; 
            gap: 1rem; margin-top: 2rem; }
        
        .btn {
            flex: 1; 
            padding: 0.85rem; 
            font-size: 1rem; 
            font-weight: 600;
            border-radius: 8px; 
            border: none; 
            cursor: pointer; 
            transition: all 0.2s ease;
            text-align: center; 
            text-decoration: none; 
            display: inline-flex;
            align-items: center; 
            justify-content: center;
        }

        .btn-submit { background-color: var(--warning); 
            color: white; }

        .btn-submit:hover { background-color: var(--warning-hover); 
            transform: translateY(-1px); }

        .btn-back { background-color: #e2e8f0; 
            color: var(--text-main); }

        .btn-back:hover { background-color: #cbd5e1; }

        @media (max-width: 480px) {
            .form-container { padding: 1.5rem; }
            .btn-group { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2>Edit Produk</h2>
        <p>Ubah detail produk di bawah ini.</p>
    </div>

    <form action="index.php?action=update&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" id="nama" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($product['harga']) ?>" min="0" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="stok">Jumlah Stok</label>
            <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($product['stok']) ?>" min="0" required>
        </div>

        <div class="form-group">
            <label for="gambar">Ganti Gambar (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            
            <?php if (!empty($product['gambar'])): ?>
                <div class="current-file">
                    📁 Gambar saat ini: <?= basename($product['gambar']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-submit">🔄 Update Data</button>
            <a href="index.php" class="btn btn-back">Batal</a>
        </div>
    </form>
</div>

</body>
</html>