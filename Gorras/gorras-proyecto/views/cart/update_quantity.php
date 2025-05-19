
<?php
require_once '../../config/database.php';
require_once '../../models/Cart.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['itemId']) || !isset($data['quantity'])) {
        throw new Exception('Datos incompletos');
    }

    $database = new Database();
    $db = $database->getConnection();
    $cart = new Cart($db);

    if ($cart->updateQuantity($data['itemId'], $data['quantity'])) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Error al actualizar cantidad');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}