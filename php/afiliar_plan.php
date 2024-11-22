<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está logueado, redirigir al inicio de sesión
    header("Location: inicio_sesion.php");
    exit();
}

require_once 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si se ha recibido el plan
if (isset($_POST['plan'])) {
    $plan = $_POST['plan'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insertar la afiliación en la base de datos
    $sql = $conn->prepare("INSERT INTO afiliaciones (usuario_id, plan) VALUES (?, ?)");
    $sql->bind_param("is", $usuario_id, $plan);

    if ($sql->execute()) {
        // Redirigir al perfil del usuario
        header("Location: perfil.php");
        exit();
    } else {
        echo "<script>alert('Error al afiliarse al plan');</script>";
    }
}
$conn->close();
?>