<?php
session_start();

header("Content-Type: application/json");

// Configuración de la base de datos
require_once '../config/database.php';
$database = new Database();
$conn = $database->getConnection();

if ($conn === null) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$action = $data['action'] ?? '';

if ($action === 'login') {
    // Inicio de sesión
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Correo y contraseña son obligatorios"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Correo no registrado"]);
        exit;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    }

} elseif ($action === 'register') {
    // Registro de usuario
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Verificar si el correo ya está registrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo json_encode(["success" => false, "message" => "Este correo ya está registrado"]);
        exit;
    }

    // Insertar nuevo usuario
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed_password]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Registro exitoso. ¡Bienvenido!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar usuario"]);
    }

} else {
    echo json_encode(["success" => false, "message" => "Acción no válida"]);
}
?>