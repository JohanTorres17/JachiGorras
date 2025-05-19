<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JachiGorras - Login</title>
    <link rel="stylesheet" href="../../public/css/styleregister.css">
</head>
<body>

<!-- Mostrar mensajes -->
<?php if (isset($_GET['error'])): ?>
    <div class="alert error"><?= urldecode($_GET['error']) ?></div>
<?php elseif (isset($_GET['success'])): ?>
    <div class="alert success"><?= urldecode($_GET['success']) ?></div>
<?php endif; ?>

<main class="container_log">
    <img src="../../public/img/FondoLogin.jfif" alt="Logo JachiGorras" class="logo">

    <!-- Contenedor para mostrar mensajes -->
    <div id="message-box" style="display: none; padding: 10px; margin: 10px auto; max-width: 400px;"></div>

    <!-- LOGIN -->
    <form id="loginForm" class="login-form" action="" method="POST">
        <input type="email" name="email" required placeholder="mail@example.com" />
        <input type="password" name="password" required placeholder="********" />
        <button type="submit">Iniciar Sesión</button>
        <p>¿No tienes cuenta? <a href="#" id="toggleToRegister">Regístrate</a></p>
    </form>

    <!-- REGISTRO -->
    <form id="registerForm" class="register-form" action="" method="POST" style="display: none;">
        <input type="text" name="name" required placeholder="Tu nombre" />
        <input type="email" name="email" required placeholder="mail@example.com" />
        <input type="password" name="password" required placeholder="********" />
        <button type="submit">Registrar</button>
        <p>¿Ya tienes cuenta? <a href="#" id="toggleToLogin">Inicia Sesión</a></p>
    </form>
</main>

<script src="../../public/js/login.js"></script>
</body>
</html>