<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Hanya terima method GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method tidak diizinkan. Gunakan GET."
    ]);
    exit();
}

try {
    $query = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($query);
    
    if ($result) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                "id" => (int)$row['id'],
                "nama_produk" => $row['nama_produk'],
                "harga" => (float)$row['harga'],
                "stok" => (int)$row['stok'],
                "gambar" => $row['gambar'],
                "tanggal_masuk" => $row['tanggal_masuk']
            ];
        }
        
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Data berhasil diambil",
            "data" => $products,
            "count" => count($products)
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Gagal mengambil data",
            "error" => $conn->error
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Terjadi kesalahan server",
        "error" => $e->getMessage()
    ]);
}

$conn->close();
?>