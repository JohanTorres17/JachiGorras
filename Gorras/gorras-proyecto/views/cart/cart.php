<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - JachiGorras</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/stylecar.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../../views/home/homepage.php">Inicio</a></li>
                <li><a href="../../views/shop/catalog.php">Tienda</a></li>
                <li><a href="../../views/cart/cart.php">Carrito</a></li>
                <li><a href="../../views/about/about.php">Sobre Nosotros</a></li>
                <li><a href="../../views/auth/login.php">Iniciar Sesión</a></li>
                <li><a href="../../views/auth/register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>

    <main class="cart-container">
        <h1>Tu Carrito</h1>
        <div id="cart-items" class="cart-items">
            <!-- Cart items will be loaded dynamically -->
            <p>Cargando productos...</p>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Gorras Store. Todos los derechos reservados.</p>
    </footer>
    <script src="../../public/js/cart.js"></script>
</body>
</html>