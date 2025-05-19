<?php
// Define la URL base del proyecto
define('BASE_URL', '/Gorras/gorras-proyecto/public/');

// Se incluyen los controladores necesarios
require_once __DIR__ . '/../controllers/HomeController.php';
require_once '../controllers/ShopController.php';
require_once '../controllers/CartController.php';

// Se obtiene el controlador y la acción desde los parámetros de la URL, con valores predeterminados
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Se utiliza un switch para manejar las rutas según el controlador solicitado
switch($controller) {
    case 'home':
        // Si el controlador es 'home', se instancia HomeController y se llama a su método index
        $controller = new HomeController();
        $controller->index();
        break;
    case 'shop':
        // Si el controlador es 'shop', se instancia ShopController y se llama a su método catalog
        $controller = new ShopController();
        $controller->catalog();
        break;
    case 'cart':
        // Si el controlador es 'cart', se instancia CartController
        $controller = new CartController();
        if ($action === 'add') {
            // Si la acción es 'add', se llama al método add
            $controller->add();
        } else if ($action === 'view') {
            // Si la acción es 'view', se llama al método viewCart
            $controller->viewCart();
        }
        break;
    default:
        // Si el controlador no coincide con ninguno de los casos, se devuelve un error 404
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
        break;
}