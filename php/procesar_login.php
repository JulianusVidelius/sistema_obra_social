<?php
session_start();
require_once 'conexion.php';

// Contraseña encriptada
$contraseña = password_hash('admin', PASSWORD_DEFAULT);

// Insertar usuario admin en la base de datos
$sql = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
$sql->bind_param("sssss", $nombre1, $apellido1, $email1, $contraseña, $rol1);

// Detalles del administrador
$nombre1 = 'Administrador';
$apellido1 = 'Principal';
$email1 = 'admin@example.com';
$rol1 = 'admin';

// Ejecutar el insert
// Verificar si el usuario admin ya existe
$sql = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$sql->bind_param("s", $email1);
$sql->execute();
$resultado = $sql->get_result();

if ($resultado->num_rows > 0) {
    echo "El usuario admin ya existe en la base de datos.";
} else {
    // Insertar usuario admin en la base de datos
    $sql = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $nombre1, $apellido1, $email1, $contraseña, $rol1);

    if ($sql->execute()) {
        echo "Usuario admin creado exitosamente.";
    } else {
        echo "Error al crear usuario admin: " . $conn->error;
    }
}
$sql->close(); // Cerrar la consulta antes de continuar

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['contrasena'])) {
        $email = trim($_POST['email']);
        $contrasena = trim($_POST['contrasena']);

        // Consultar el usuario por correo electrónico
        $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $resultado = $sql->get_result();

        // Si existe el usuario
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
// Eliminar el usuario admin si ya existe
$conn->query("DELETE FROM usuarios WHERE email = 'admin@example.com'");

// Insertar el usuario admin después de eliminar posibles duplicados
$sql = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
$sql->bind_param("sssss", $nombre1, $apellido1, $email1, $contraseña, $rol1);

if ($sql->execute()) {
    echo "Usuario admin creado exitosamente.";
} else {
    echo "Error al crear usuario admin: " . $conn->error;
}

            // Verificar la contraseña
            if (password_verify($contrasena, $usuario['contrasena'])) {
                // Iniciar sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_apellido'] = $usuario['apellido'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];

                // Redirigir según el rol
                if ($usuario['rol'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: perfil.php");
                }
                exit();
            } else {
                echo "<script>alert('Contraseña incorrecta.'); window.location.href='../html/inicio_sesion.html';</script>";
            }
        } else {
            echo "<script>alert('Correo electrónico no registrado.'); window.location.href='../html/inicio_sesion.html';</script>";
        }

        $sql->close();
        $conn->close();
    } else {
        echo "<script>alert('Por favor ingrese todos los datos requeridos.'); window.location.href='../html/inicio_sesion.html';</script>";
    }
}
?>
