<?php
require_once 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener al usuario con su rol
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['contrasena'])) {
            // Guardar datos en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_apellido'] = $usuario['apellido'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_rol'] = $usuario['rol']; // Nuevo: guardar el rol en la sesión

            // Redirigir según el rol del usuario
            if ($usuario['rol'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: perfil.php");
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El correo no está registrado.";
    }

    $sql->close();
    $conn->close();
}
?>
