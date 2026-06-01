<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Hanya terima method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method tidak diizinkan. Gunakan POST."
    ]);
    exit();
}

// Ambil data dari request body
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data yang diperlukan
$nama_produk = trim($data['nama_produk'] ?? '');
$harga = $data['harga'] ?? 0;
$stok = $data['stok'] ?? 0;
$gambar = $data['gambar'] ?? null;

if (empty($nama_produk)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Nama produk wajib diisi"
    ]);
    exit();
}

if ($harga < 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Harga tidak boleh negatif"
    ]);
    exit();
}

if ($stok < 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Stok tidak boleh negatif"
    ]);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO products (nama_produk, harga, stok, gambar, tanggal_masuk) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("sdis", $nama_produk, $harga, $stok, $gambar);
    
    if ($stmt->execute()) {
        $new_id = $conn->insert_id;
        
        http_response_code(201);
        echo json_encode([
            "success" => true,
            "message" => "Produk berhasil ditambahkan",
            "data" => [
                "id" => (int)$new_id,
                "nama_produk" => $nama_produk,
                "harga" => (float)$harga,
                "stok" => (int)$stok,
                "gambar" => $gambar
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Gagal menambahkan produk",
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