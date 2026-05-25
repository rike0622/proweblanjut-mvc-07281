<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $model;
    private $uploadDir = __DIR__ . '/../../assets/uploads/';

    public function __construct($db) {
        $this->model = new Product($db);
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
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            $target = $this->uploadDir . $filename;
            move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
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

    public function update($id) {
        $filename = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
            $filename = time() . '_' . basename($_FILES['gambar']['name']);
            $target = $this->uploadDir . $filename;
  
            $oldProduct = $this->model->getById($id);
            if (!empty($oldProduct['gambar']) && file_exists($oldProduct['gambar'])) {
                unlink($oldProduct['gambar']);
            }
            move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
        }

        $data = [
            'nama_produk' => $_POST['nama_produk'],
            'harga' => (float)$_POST['harga'],
            'stok' => (int)$_POST['stok'],
            'gambar' => $filename 
        ];

        $this->model->update($id, $data);
        header("Location: index.php");
        exit;
    }

    public function delete($id) {
        $product = $this->model->getById($id);
        if ($product && !empty($product['gambar'])) {
            if (file_exists($product['gambar'])) {
                unlink($product['gambar']);
            }
        }
        $this->model->delete($id);
        header("Location: index.php");
        exit;
    }
}
?>