
<?php
require_once '../../config/database.php';
require_once '../../models/Cart.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['itemId'])) {
        throw new Exception('ID de item no especificado');
    }

    $database = new Database();
    $db = $database->getConnection();
    $cart = new Cart($db);

    if ($cart->removeItem($data['itemId'])) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Error al eliminar item');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}