
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JachiGorras - Tienda</title>
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

    <main class="shop-container">
            <div class="product-grid">
                <?php if(!empty($productsArray)): ?>
                    <?php foreach($productsArray as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                            <div class="product-info">
                                <h3><?php echo $product['name']; ?></h3>
                                <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                                <button class="add-to-cart" data-id="<?php echo $product['id']; ?>">Añadir al carrito</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 JachiGorras. Todos los derechos reservados.</p>
    </footer>
    <script src="../../public/js/catalog.js"></script>
</body>
</html>