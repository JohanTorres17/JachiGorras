<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class HomeController {
    private $productModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new Product($this->db);
    }

    public function index() {
        // Obtener productos destacados
        $featuredProducts = $this->productModel->getFeaturedProducts();
        
        // Usar count() porque es un array
        echo "<!-- Debug Controller: Productos encontrados: " . (is_array($featuredProducts) ? count($featuredProducts) : '0') . " -->";
        
        include '../views/home/homepage.php';
    }

    // Método para obtener productos destacados
    public function getFeaturedProducts() {
    $database = new Database();
    $db = $database->getConnection();

    $productModel = new Product($db);
    return $productModel->getFeaturedProducts();
}
}