# Contents of /gorras-proyecto/gorras-proyecto/README.md

# Gorras Proyecto

Este proyecto es una aplicación web para gestionar gorras. Permite a los usuarios crear, editar y listar gorras, así como gestionar usuarios.

## Estructura del Proyecto

- **controllers/**: Contiene los controladores que manejan la lógica de la aplicación.
  - `GorraController.php`: Controlador para manejar las gorras.
  - `UserController.php`: Controlador para manejar los usuarios.
  - `HomeController.php`: Controlador para manejar la página de inicio.

- **models/**: Contiene los modelos de datos.
  - `Gorra.php`: Modelo que representa una gorra.
  - `User.php`: Modelo que representa un usuario.

- **views/**: Contiene las vistas de la aplicación.
  - `home/index.php`: Vista para la página de inicio.
  - `gorras/`: Vistas relacionadas con las gorras.
    - `list.php`: Vista para listar gorras.
    - `edit.php`: Vista para editar una gorra.
    - `create.php`: Vista para crear una nueva gorra.
  - `users/`: Vistas relacionadas con los usuarios.
    - `list.php`: Vista para listar usuarios.
    - `edit.php`: Vista para editar un usuario.

- **public/**: Contiene archivos accesibles públicamente.
  - `index.php`: Punto de entrada de la aplicación.

- **config/**: Contiene la configuración de la aplicación.
  - `database.php`: Configuración de la base de datos.

## Instalación

1. Clona el repositorio.
2. Configura la base de datos en `config/database.php`.
3. Accede a `public/index.php` para iniciar la aplicación.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request para discutir cambios.