<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'agregar') {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];

        $sql = "INSERT INTO planes (nombre, precio, descripcion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sds", $nombre, $precio, $descripcion);

        if ($stmt->execute()) {
            header('Location: admin_dashboard.php');
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($accion === 'eliminar') {
        $id = $_POST['id'];

        $sql = "DELETE FROM planes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: admin_dashboard.php');
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
