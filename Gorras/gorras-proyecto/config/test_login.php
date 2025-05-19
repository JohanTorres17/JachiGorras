<?php
// test_registro.php

// Conexión a la base de datos
try {
    $host = 'localhost';
    $db_name = 'gorras_db';
    $username = 'root';
    $password = ''; // Cambia esto si tu MySQL tiene contraseña

    $conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Conexión exitosa a la base de datos<br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($name) || empty($email) || empty($password)) {
            die("❌ Todos los campos son obligatorios.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);

        if ($stmt->execute()) {
            echo "🎉 Registro exitoso!";
        } else {
            echo "❌ Error al registrar usuario.";
        }
    }
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Registro</title>
</head>
<body>
    <h2>Formulario de Registro</h2>
    <form method="POST" action="">
        <label>Nombre:
            <input type="text" name="name" required>
        </label><br><br>

        <label>Email:
            <input type="email" name="email" required>
        </label><br><br>

        <label>Contraseña:
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>