<?php
require_once 'conexion.php'; // Asegúrate de incluir el archivo de conexión

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validar que las contraseñas coincidan
    if ($password !== $password_confirm) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para insertar el nuevo usuario
    $sql = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $nombre, $apellido, $email, $password_hash);

    // Ejecutar la consulta
    if ($sql->execute()) {
        echo "Cuenta creada exitosamente.";
        // Redirigir al inicio de sesión o página de perfil
        header("Location: ../html/inicio_sesion.html");
    } else {
        echo "Error al crear la cuenta. Intenta nuevamente.";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
