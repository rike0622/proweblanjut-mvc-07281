<?php
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM products ORDER BY tanggal_masuk DESC");
        $data = [];
        while ($row = $result->fetch_assoc()) { $data[] = $row; }
        return $data;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO products (nama_produk, harga, stok, gambar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $data['nama_produk'], $data['harga'], $data['stok'], $data['gambar']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        // Selalu update gambar agar sinkron dengan controller
        $stmt = $this->conn->prepare("UPDATE products SET nama_produk=?, harga=?, stok=?, gambar=? WHERE id=?");
        $stmt->bind_param("sdisi", $data['nama_produk'], $data['harga'], $data['stok'], $data['gambar'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>