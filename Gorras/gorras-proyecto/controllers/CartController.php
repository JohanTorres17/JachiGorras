<?php
require_once '../models/Cart.php';
require_once '../models/Product.php';
// Controlador del carrito de compras //
class CartController {
    private $cartModel;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->cartModel = new Cart($db);
        $this->productModel = new Product($db);
    }

    public function add() {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['productId'])) {
                throw new Exception('ID de producto no especificado');
            }

            $user_id = 1; // Temporal hasta implementar autenticación
            $product_id = $data['productId'];
            $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;

            // Verificar si el producto existe
            if (!$this->productModel->getById($product_id)) {
                throw new Exception('Producto no encontrado');
            }

            if ($this->cartModel->addToCart($user_id, $product_id, $quantity)) {
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
    }

    public function viewCart() {
        $user_id = 1; // Temporal hasta implementar autenticación
        $cartItems = $this->cartModel->getCartItems($user_id);
        $total = $this->cartModel->getCartTotal($user_id);
        require_once '../views/cart/shopping-cart.php';
    }
}