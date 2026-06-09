<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

$authController = new AuthController($conn);
$productController = new ProductController($conn);

switch ($page) {
    case 'login':
        if ($action === 'process') {
            $authController->processLogin();
        } else {
            $authController->login();
        }
        break;
        
    case 'register':
        if ($action === 'process') {
            $authController->processRegister();
        } else {
            $authController->register();
        }
        break;
        
    case 'dashboard':
        $authController->dashboard();
        break;
        
    case 'logout':
        $authController->logout();
        break;
        
    case 'products':
        // ✅ Cek login dulu
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        // ✅ Handle semua action produk
        switch ($action) {
            case 'create':
                $productController->create();
                break;
            case 'store':
                $productController->store();
                break;
            case 'edit':
                $productController->edit($id);
                break;
            case 'update':
                $productController->update($id);
                break;
            case 'delete':
                $productController->delete($id);
                break;
            default:
                $productController->index();
                break;
        }
        break;
        
    default:
        header("Location: index.php?page=login");
        exit;
}
?>