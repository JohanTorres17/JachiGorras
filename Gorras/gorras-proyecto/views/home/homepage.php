<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JachiGorras- Inicio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styles.css">
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

    <main class="home-container">
        <section class="hero">
            <div class="hero-content">
                <h1>Bienvenido a JachiGorras</h1>
                <p>Encuentra las mejores gorras para tu estilo</p>
                <a href="../../views/shop/catalog.php" class="cta-button">Ver Catálogo</a>
            </div>
        </section>

        <section class="featured-products">
            <h2>Productos Destacados</h2>
            <div class="product-grid">
                <p>Cargando productos destacados...</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Gorras Store. Todos los derechos reservados.</p>
    </footer>
    <script src="../../public/js/homepage.js"></script>
</body>
</html>