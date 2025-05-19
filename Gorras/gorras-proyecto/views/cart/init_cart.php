<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/Cart.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

// Inicializar la conexión y el modelo
$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);

$user_id = $_SESSION['user_id'];

// Obtener items del carrito
$cartItems = $cart->getCartItems($user_id);
$total = $cart->getCartTotal($user_id);

// Devolver JSON si es una petición AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');
    echo json_encode([
        'items' => $cartItems->fetchAll(PDO::FETCH_ASSOC),
        'total' => $total
    ]);
    exit;
}