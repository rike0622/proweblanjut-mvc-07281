<?php
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM products ORDER BY id DESC");
        
        if (!$result) {
            error_log("Query error: " . $this->conn->error);
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function getBestSellers($limit = 5) {
        $result = $this->conn->query("
            SELECT * FROM products 
            WHERE terjual > 0 
            ORDER BY terjual DESC 
            LIMIT $limit
        ");
        
        if (!$result) {
            error_log("Query error: " . $this->conn->error);
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO products (nama_produk, harga, stok, terjual, gambar, tanggal_masuk) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            $terjual = $data['terjual'] ?? 0;
            
            $stmt->bind_param(
                "sdisi",
                $data['nama_produk'],
                $data['harga'],
                $data['stok'],
                $terjual,
                $data['gambar']
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Create error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE products 
                SET nama_produk = ?, harga = ?, stok = ?, terjual = ?, gambar = ? 
                WHERE id = ?
            ");
            
            $terjual = $data['terjual'] ?? 0;
            
            $stmt->bind_param(
                "sdisii",
                $data['nama_produk'],
                $data['harga'],
                $data['stok'],
                $terjual,
                $data['gambar'],
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Update error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>