<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $model;
    private $uploadDir;

    public function __construct($db) {
        $this->model = new Product($db);
        $this->uploadDir = __DIR__ . '/../../assets/uploads/';
        
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
        $nama_produk = trim($_POST['nama_produk'] ?? '');
        $harga = isset($_POST['harga']) ? (float)$_POST['harga'] : 0;
        $stok = isset($_POST['stok']) ? (int)$_POST['stok'] : 0;

        $terjual = isset($_POST['terjual']) ? (int)$_POST['terjual'] : 0;
        
        $gambar = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['gambar']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $newFilename = time() . '_' . uniqid() . '.' . $ext;
                $target = $this->uploadDir . $newFilename;
                
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $gambar = $newFilename;
                }
            }
        }

        if (empty($nama_produk)) {
            $_SESSION['error'] = "Nama produk wajib diisi!";
            header("Location: index.php?page=products&action=create");
            exit;
        }
        
        $data = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'stok' => $stok,
            'terjual' => $terjual,
            'gambar' => $gambar
        ];
        
        try {
            if ($this->model->create($data)) {
                $_SESSION['success'] = "Produk berhasil ditambahkan!";
                header("Location: index.php?page=products");
                exit;
            } else {
                $_SESSION['error'] = "Gagal menambahkan produk ke database!";
                header("Location: index.php?page=products&action=create");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: index.php?page=products&action=create");
            exit;
        }
    }

    public function edit($id) {
        $product = $this->model->getById($id);
        if (!$product) {
            $_SESSION['error'] = "Produk tidak ditemukan!";
            header("Location: index.php?page=products");
            exit;
        }
        require __DIR__ . '/../views/products/edit.php';
    }

    public function update($id) {
        $nama_produk = trim($_POST['nama_produk'] ?? '');
        $harga = isset($_POST['harga']) ? (float)$_POST['harga'] : 0;
        $stok = isset($_POST['stok']) ? (int)$_POST['stok'] : 0;
        $terjual = isset($_POST['terjual']) ? (int)$_POST['terjual'] : 0;
        
        $oldProduct = $this->model->getById($id);
        $gambar = $oldProduct['gambar'] ?? '';
        
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['gambar']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $newFilename = time() . '_' . uniqid() . '.' . $ext;
                $target = $this->uploadDir . $newFilename;
                
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    if (!empty($gambar) && file_exists($this->uploadDir . $gambar)) {
                        unlink($this->uploadDir . $gambar);
                    }
                    $gambar = $newFilename;
                }
            }
        }
        
        if (empty($nama_produk)) {
            $_SESSION['error'] = "Nama produk wajib diisi!";
            header("Location: index.php?page=products&action=edit&id=" . $id);
            exit;
        }

        $data = [
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'stok' => $stok,
            'terjual' => $terjual,
            'gambar' => $gambar
        ];
        
        if ($this->model->update($id, $data)) {
            $_SESSION['success'] = "Produk berhasil diupdate!";
            header("Location: index.php?page=products");
            exit;
        } else {
            $_SESSION['error'] = "Gagal update produk!";
            header("Location: index.php?page=products&action=edit&id=" . $id);
            exit;
        }
    }

    public function delete($id) {
        $product = $this->model->getById($id);
        
        if ($product) {
            if (!empty($product['gambar']) && file_exists($this->uploadDir . $product['gambar'])) {
                unlink($this->uploadDir . $product['gambar']);
            }
            
            if ($this->model->delete($id)) {
                $_SESSION['success'] = "Produk berhasil dihapus!";
            } else {
                $_SESSION['error'] = "Gagal hapus produk!";
            }
        }
        
        header("Location: index.php?page=products");
        exit;
    }

    public function getAll() {
        return $this->model->getAll();
    }
}
?>