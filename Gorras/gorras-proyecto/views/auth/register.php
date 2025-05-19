<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JachiGorras - Registro</title>
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

    <!-- REGISTRO -->
    <form class="register-form" action="?controller=auth&action=processRegister" method="POST">
        <input type="text" name="username" required placeholder="Tu nombre" />
        <input type="email" name="email" required placeholder="mail@example.com" />
        <input type="password" name="password" required placeholder="********" />
        <button type="submit">Registrar</button>
        <a href="?controller=auth&action=login" id="show-login">Inicia Sesión</a>
    </form>
</main>
</body>
</html>