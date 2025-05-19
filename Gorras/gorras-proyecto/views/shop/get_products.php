
<?php
require_once '../../config/database.php';
require_once '../../models/Product.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $products = $category ? $product->getByCategory($category) : $product->getAll();
    
    header('Content-Type: application/json');
    echo json_encode($products->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}