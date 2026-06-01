<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Terima method PUT atau POST
if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method tidak diizinkan. Gunakan PUT atau POST."
    ]);
    exit();
}

// Ambil data dari request body
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? 0;
$nama_produk = trim($data['nama_produk'] ?? '');
$harga = $data['harga'] ?? 0;
$stok = $data['stok'] ?? 0;
$gambar = $data['gambar'] ?? null;

// Validasi
if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "ID produk tidak valid"
    ]);
    exit();
}

if (empty($nama_produk)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Nama produk wajib diisi"
    ]);
    exit();
}

// Cek apakah produk ada
$check = $conn->prepare("SELECT id FROM products WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "Produk tidak ditemukan"
    ]);
    exit();
}

$check->close();

try {
    $stmt = $conn->prepare("UPDATE products SET nama_produk=?, harga=?, stok=?, gambar=? WHERE id=?");
    $stmt->bind_param("sdisi", $nama_produk, $harga, $stok, $gambar, $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Produk berhasil diupdate",
                "data" => [
                    "id" => (int)$id,
                    "nama_produk" => $nama_produk,
                    "harga" => (float)$harga,
                    "stok" => (int)$stok,
                    "gambar" => $gambar
                ]
            ]);
        } else {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Tidak ada perubahan data"
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Gagal mengupdate produk",
            "error" => $stmt->error
        ]);
    }
    
    $stmt->close();
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