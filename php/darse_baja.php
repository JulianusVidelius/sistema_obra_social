<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../html/inicio_sesion.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Eliminar la afiliación del usuario
$sql = $conn->prepare("DELETE FROM afiliaciones WHERE usuario_id = ?");
$sql->bind_param("i", $usuario_id);

if ($sql->execute()) {
    echo "<script>alert('Te has dado de baja exitosamente.');</script>";
} else {
    echo "<script>alert('Error al intentar darse de baja.');</script>";
}

// Redirigir al perfil
header("Location: perfil.php");
exit();
?>
