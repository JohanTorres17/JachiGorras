<?php
require_once '../../config/database.php';
require_once '../../models/Cart.php';
require_once '../../models/Product.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data');
    }

    if (!isset($data['productId'])) {
        throw new Exception('ID de producto no especificado');
    }

    $database = new Database();
    $db = $database->getConnection();
    
    // Get test user ID
    $stmt = $db->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception('No user found in database');
    }

    $cart = new Cart($db);
    $productModel = new Product($db);

    if (!$productModel->getById($data['productId'])) {
        throw new Exception('Producto no encontrado');
    }

    $user_id = $user['id']; // Use actual user ID from database
    $product_id = $data['productId'];
    $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;

    if ($cart->addToCart($user_id, $product_id, $quantity)) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto agregado al carrito'
        ]);
    } else {
        throw new Exception('Error al agregar al carrito');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}