<?php
require_once '../config/database.php';
require_once '../models/Product.php';
// Controlador de la tienda de los productos  //
class ShopController {
    private $productModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new Product($this->db);
    }
// Funcion del catalogo //
    public function catalog() {
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
        
        if ($category) {
            $products = $this->productModel->getByCategory($category);
        } else {
            $products = $this->productModel->getAll();
        }

        $productsArray = $products->fetchAll(PDO::FETCH_ASSOC);

        // Si es una petición AJAX, devolver JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($productsArray);
            exit;
        }
        require_once '../views/shop/catalog.php';
    }

    public function getProduct($id) {
        return $this->productModel->getById($id);
    }

    public function searchProducts($query) {
        return $this->productModel->search($query);
    }
}