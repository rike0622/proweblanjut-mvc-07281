<?php
require_once __DIR__ . '/../models/product.php';

class ProductController {
    private $model;
    private $uploadDir;

    public function __construct($db) {
        $this->model = new Product($db);
        // Path absolut ke folder uploads agar tidak error di manapun script dijalankan
        $this->uploadDir = realpath(__DIR__ . '/../../assets/uploads') . '/';
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index() {
        $data = $this->model->getAll();
        require __DIR__ . '/../views/products/index.php';
    }

    public function create() {
        require __DIR__ . '/../views/products/create.php';
    }

    public function store() {
        $filename = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            move_uploaded_file($_FILES['gambar']['tmp_name'], $this->uploadDir . $filename);
        }

        $data = [
            'nama_produk' => $_POST['nama_produk'],
            'harga' => (float)$_POST['harga'],
            'stok' => (int)$_POST['stok'],
            'gambar' => $filename
        ];

        $this->model->create($data);
        header("Location: index.php");
        exit;
    }

    public function edit($id) {
        $product = $this->model->getById($id);
        if (!$product) die("Produk tidak ditemukan");
        require __DIR__ . '/../views/products/edit.php';
    }

    // ✅ LOGIC UPDATE YANG DIPERBAIKI
    public function update($id) {
        $oldProduct = $this->model->getById($id);
        $currentGambar = $oldProduct['gambar'] ?? '';

        // Default: pertahankan gambar lama
        $newGambar = $currentGambar;

        // Jika ada file baru yang diupload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            $target = $this->uploadDir . $filename;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                // Hapus gambar lama hanya jika upload baru berhasil
                if (!empty($currentGambar)) {
                    $oldFilePath = $this->uploadDir . basename($currentGambar);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $newGambar = $filename; // Ganti dengan nama file baru
            }
        }

        $data = [
            'nama_produk' => $_POST['nama_produk'],
            'harga' => (float)$_POST['harga'],
            'stok' => (int)$_POST['stok'],
            'gambar' => $newGambar // Selalu isi (bisa lama atau baru)
        ];

        $this->model->update($id, $data);
        header("Location: index.php");
        exit;
    }

    public function delete($id) {
        $product = $this->model->getById($id);
        if ($product && !empty($product['gambar'])) {
            $filePath = $this->uploadDir . basename($product['gambar']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $this->model->delete($id);
        header("Location: index.php");
        exit;
    }
}
?>