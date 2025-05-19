<?php
require_once '../../config/database.php';
require_once '../../models/Cart.php';

header('Content-Type: application/json');

try {
    $database = new Database();
    $db = $database->getConnection();
    $cart = new Cart($db);

    // Get test user for now
    $stmt = $db->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception('Usuario no encontrado');
    }

    // Start transaction
    $db->beginTransaction();

    // Create sale record
    $total = $cart->getCartTotal($user['id']);
    $stmt = $db->prepare("INSERT INTO sales (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$user['id'], $total]);
    $sale_id = $db->lastInsertId();

    // Get cart items
    $cartItems = $cart->getCartItems($user['id'])->fetchAll(PDO::FETCH_ASSOC);

    // Insert sale items
    $stmt = $db->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->execute([$sale_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    // Clear cart
    $cart->clearCart($user['id']);

    // Commit transaction
    $db->commit();

    echo json_encode([
        'success' => true,
        'message' => '¡Compra realizada con éxito!'
    ]);

} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}