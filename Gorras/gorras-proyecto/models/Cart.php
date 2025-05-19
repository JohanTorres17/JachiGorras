<?php
require_once __DIR__ . '/../config/database.php';
class Cart {
    private $conn;
    private $table_name = "cart";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addToCart($user_id, $product_id, $quantity = 1) {
        // Verificar si el producto ya está en el carrito
        $check_query = "SELECT * FROM " . $this->table_name . 
                    " WHERE user_id = ? AND product_id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->execute([$user_id, $product_id]);

        if ($check_stmt->rowCount() > 0) {
            // Actualizar cantidad si el producto ya existe
            $update_query = "UPDATE " . $this->table_name . 
                        " SET quantity = quantity + ? 
                            WHERE user_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($update_query);
            return $stmt->execute([$quantity, $user_id, $product_id]);
        } else {
            // Insertar nuevo item si el producto no existe
            $insert_query = "INSERT INTO " . $this->table_name . 
                        " (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($insert_query);
            return $stmt->execute([$user_id, $product_id, $quantity]);
        }
    }

    public function getCartItems($user_id) {
        $query = "SELECT c.*, p.name, p.price, p.image_url 
                FROM " . $this->table_name . " c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt;
    }

    public function updateQuantity($cart_id, $quantity) {
        $query = "UPDATE " . $this->table_name . 
                " SET quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $cart_id]);
    }

    public function removeItem($cart_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cart_id]);
    }

    public function getCartTotal($user_id) {
        $query = "SELECT SUM(c.quantity * p.price) as total 
                FROM " . $this->table_name . " c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function clearCart($user_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}