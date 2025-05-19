<?php
// Se incluye el archivo de configuración de la base de datos
require_once '../config/database.php';

// Clase User que representa a un usuario en el sistema
class User {
    // Propiedades privadas para la conexión y el nombre de la tabla
    private $conn; // Conexión a la base de datos
    private $table_name = "users"; // Nombre de la tabla en la base de datos

    // Propiedades públicas que representan los campos de la tabla
    public $id; // ID del usuario
    public $name; // Nombre del usuario (anteriormente llamado username)
    public $email; // Correo electrónico del usuario
    public $password; // Contraseña del usuario

    // Constructor de la clase
    public function __construct() {
        // Se crea una nueva instancia de la clase Database y se obtiene la conexión
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para crear un nuevo usuario en la base de datos
    public function create() {
        // Consulta SQL para insertar un nuevo registro en la tabla
        $query = "INSERT INTO " . $this->table_name . " 
                (name, email, password) 
                VALUES (:name, :email, :password)";

        // Se prepara la consulta
        $stmt = $this->conn->prepare($query);

        // Se encripta la contraseña antes de guardarla en la base de datos
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Se vinculan los parámetros con los valores de las propiedades
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        // Se ejecuta la consulta y se devuelve el resultado
        return $stmt->execute();
    }

    // Método para iniciar sesión con un correo electrónico y contraseña
    public function login($email, $password) {
        // Consulta SQL para buscar un usuario por correo electrónico
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Se vincula el parámetro del correo electrónico
        $stmt->bindParam(":email", $email);

        // Se ejecuta la consulta
        $stmt->execute();

        // Se verifica si se encontró un registro
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Se verifica si la contraseña proporcionada coincide con la almacenada
            if (password_verify($password, $row['password'])) {
                return $row; // Devuelve todos los datos del usuario si la contraseña es correcta
            }
        }
        // Devuelve false si no se encontró el usuario o la contraseña no coincide
        return false;
    }
}