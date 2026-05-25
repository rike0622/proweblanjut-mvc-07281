<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/productcontroller.php';

$controller = new ProductController($conn);

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'index':   $controller->index();   break;
    case 'create':  $controller->create();  break;
    case 'store':   $controller->store();   break;
    case 'edit':    $controller->edit($id); break;
    case 'update':  $controller->update($id); break;
    case 'delete':  $controller->delete($id); break;
    default:        $controller->index();   break;
}
?>