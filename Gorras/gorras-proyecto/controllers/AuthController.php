<?php
session_start();

require_once '../models/User.php';

class AuthController {
    private $userModel;
    public function __construct() {
        session_start(); // Solo iniciamos sesión aquí
        $this->userModel = new User();
    }

public function processLogin() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            header("Location: ?controller=auth&action=login&error=" . urlencode("Correo y contraseña son obligatorios."));
            exit();
        }

        $user = $this->userModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: ../views/home/homepage.php?success=" . urlencode("Bienvenido de nuevo, " . $user['name']));
            exit();
        } else {
            header("Location: ?controller=auth&action=login&error=" . urlencode("Credenciales incorrectas."));
            exit();
        }
    }
}

    // Procesa el registro
    public function processRegister() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($name) || empty($email) || empty($password)) {
                header("Location: ?controller=auth&action=register&error=" . urlencode("Todos los campos son obligatorios."));
                exit();
            }

            $this->userModel->name = $name;
            $this->userModel->email = $email;
            $this->userModel->password = $password;

            if ($this->userModel->create()) {
                header("Location: ?controller=auth&action=login&success=" . urlencode("Registro exitoso. ¡Bienvenido!"));
            } else {
                header("Location: ?controller=auth&action=register&error=" . urlencode("Error al registrar usuario."));
            }
            exit();
        }
    }
}