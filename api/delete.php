<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Terima method DELETE atau POST
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method tidak diizinkan. Gunakan DELETE atau POST."
    ]);
    exit();
}

// Ambil ID dari query string atau request body
$id = $_GET['id'] ?? 0;

if ($id <= 0) {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? 0;
}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "ID produk tidak valid"
    ]);
    exit();
}

// Cek apakah produk ada
$check = $conn->prepare("SELECT id, gambar FROM products WHERE id = ?");
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

$product = $result->fetch_assoc();
$check->close();

// Hapus file gambar jika ada
if (!empty($product['gambar'])) {
    $file_path = __DIR__ . '/../assets/uploads/' . basename($product['gambar']);
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Produk berhasil dihapus",
            "data" => [
                "id" => (int)$id
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Gagal menghapus produk",
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