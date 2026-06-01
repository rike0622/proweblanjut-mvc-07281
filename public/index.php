<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        
    // ✅ TAMBAHAN: Routing untuk register
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
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        
        if ($action === 'create') {
            $productController->create();
        } elseif ($action === 'store') {
            $productController->store();
        } elseif ($action === 'edit') {
            $productController->edit($id);
        } elseif ($action === 'update') {
            $productController->update($id);
        } elseif ($action === 'delete') {
            $productController->delete($id);
        } else {
            $data = $productController->getAll();
            require __DIR__ . '/../app/views/products/products_with_nav.php';
        }
        break;
        
    default:
        header("Location: index.php?page=login");
        exit;
}
?>