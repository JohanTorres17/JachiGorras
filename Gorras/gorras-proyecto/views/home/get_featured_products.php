<?php
// Encabezado para JSON
header('Content-Type: application/json');

require_once '../../controllers/HomeController.php';

$controller = new HomeController();
$products = $controller->getFeaturedProducts();

if (!empty($products)) {
    echo json_encode([
        'success' => true,
        'products' => $products
    ]);
} else {
    echo json_encode([
        'success' => false,
        'products' => []
    ]);
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


