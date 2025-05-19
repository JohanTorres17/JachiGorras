<?php
define('BASE_URL', '/Gorras/gorras-proyecto/public/');

require_once __DIR__ . '/../controllers/HomeController.php';
require_once '../controllers/ShopController.php';
require_once '../controllers/CartController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($controller) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'shop':
        $controller = new ShopController();
        $controller->catalog();
        break;
    case 'cart':
        $controller = new CartController();
        if ($action === 'add') {
            $controller->add();
        } else if ($action === 'view') {
            $controller->viewCart();
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
        break;
}