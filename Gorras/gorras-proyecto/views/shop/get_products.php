<?php
// Se incluye la configuración de la base de datos y el modelo de productos
require_once '../../config/database.php';
require_once '../../models/Product.php';

try {
    // Se crea una instancia de la base de datos y se obtiene la conexión
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    // Se verifica si se ha proporcionado una categoría en los parámetros de la URL
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    // Si hay una categoría, se obtienen los productos de esa categoría; de lo contrario, se obtienen todos
    $products = $category ? $product->getByCategory($category) : $product->getAll();
    
    // Se establece el encabezado para devolver una respuesta JSON
    header('Content-Type: application/json');
    // Se codifican los productos en formato JSON y se envían como respuesta
    echo json_encode($products->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    // En caso de error, se devuelve un mensaje de error en formato JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}