<?php
// Inicia la sesión
session_start();

// Establece el encabezado para devolver una respuesta JSON
header("Content-Type: application/json");

// Configuración de la base de datos
require_once '../config/database.php';
$database = new Database();
$conn = $database->getConnection();

// Verifica si la conexión a la base de datos es válida
if ($conn === null) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit;
}

// Obtiene los datos enviados en la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Obtiene la acción solicitada desde los datos
$action = $data['action'] ?? '';

if ($action === 'login') {
    // Inicio de sesión
    $email = $data['email'] ?? ''; // Obtiene el correo electrónico
    $password = $data['password'] ?? ''; // Obtiene la contraseña

    // Verifica si el correo y la contraseña están presentes
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Correo y contraseña son obligatorios"]);
        exit;
    }

    // Consulta para buscar el usuario por correo electrónico
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si el usuario existe
    if (!$user) {
        echo json_encode(["success" => false, "message" => "Correo no registrado"]);
        exit;
    }

    // Verifica si la contraseña proporcionada coincide con la almacenada
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Guarda el ID del usuario en la sesión
        echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    }

} elseif ($action === 'register') {
    // Registro de usuario
    $name = $data['name'] ?? ''; // Obtiene el nombre
    $email = $data['email'] ?? ''; // Obtiene el correo electrónico
    $password = $data['password'] ?? ''; // Obtiene la contraseña

    // Verifica si todos los campos están presentes
    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Verifica si el correo ya está registrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo json_encode(["success" => false, "message" => "Este correo ya está registrado"]);
        exit;
    }

    // Inserta un nuevo usuario en la base de datos
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encripta la contraseña
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed_password]);

    // Verifica si el registro fue exitoso
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Registro exitoso. ¡Bienvenido!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar usuario"]);
    }

} else {
    // Maneja acciones no válidas
    echo json_encode(["success" => false, "message" => "Acción no válida"]);
}
?>