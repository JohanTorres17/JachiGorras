
<?php
require_once '../../config/database.php';
require_once '../../models/Cart.php';

header('Content-Type: application/json');

try {
    $database = new Database();
    $db = $database->getConnection();
    $cart = new Cart($db);
    
    $user_id = 1; // Temporal hasta implementar autenticación
    $total = $cart->getCartTotal($user_id);

    echo json_encode([
        'success' => true,
        'total' => $total
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}