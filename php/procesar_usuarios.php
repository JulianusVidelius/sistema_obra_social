<?php
require_once 'conexion.php';
session_start();

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden realizar esta acción.";
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que la acción esté definida
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'asignar') {
            // Asignar un plan a un usuario
            if (!empty($_POST['usuario_id']) && !empty($_POST['plan'])) {
                $usuario_id = intval($_POST['usuario_id']);
                $plan_nombre = trim($_POST['plan']);

                // Buscar el ID del plan basado en su nombre
                $stmt = $conn->prepare("SELECT id FROM planes WHERE nombre = ?");
                $stmt->bind_param("s", $plan_nombre);
                $stmt->execute();
                $result = $stmt->get_result();
                $plan_data = $result->fetch_assoc();
                $stmt->close();

                if ($plan_data) {
                    $plan_id = $plan_data['id'];

                    // Verificar si el usuario ya tiene una afiliación
                    $checkStmt = $conn->prepare("SELECT id FROM afiliaciones WHERE usuario_id = ?");
                    $checkStmt->bind_param("i", $usuario_id);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();

                    if ($checkResult->num_rows > 0) {
                        // Actualizar afiliación existente
                        $updateStmt = $conn->prepare("UPDATE afiliaciones SET plan = ? WHERE usuario_id = ?");
                        $updateStmt->bind_param("si", $plan_nombre, $usuario_id); // Cambiado a 'plan' y no 'plan_id'
                        if ($updateStmt->execute()) {
                            echo "<script>alert('Plan actualizado exitosamente.'); window.location.href='admin_dashboard.php';</script>";
                        } else {
                            echo "<script>alert('Error al actualizar el plan: {$conn->error}'); window.location.href='admin_dashboard.php';</script>";
                        }
                        $updateStmt->close();
                    } else {
                        // Insertar nueva afiliación con el nombre del plan (plan) en lugar de plan_id
                        $insertStmt = $conn->prepare("INSERT INTO afiliaciones (usuario_id, plan) VALUES (?, ?)");
                        $insertStmt->bind_param("is", $usuario_id, $plan_nombre); // Cambiado a 'plan' y no 'plan_id'
                        if ($insertStmt->execute()) {
                            echo "<script>alert('Plan asignado exitosamente.'); window.location.href='admin_dashboard.php';</script>";
                        } else {
                            echo "<script>alert('Error al asignar el plan: {$conn->error}'); window.location.href='admin_dashboard.php';</script>";
                        }
                        $insertStmt->close();
                    }
                    $checkStmt->close();
                } else {
                    echo "<script>alert('El plan seleccionado no existe.'); window.location.href='admin_dashboard.php';</script>";
                }
            } else {
                echo "<script>alert('Por favor, complete todos los campos para asignar un plan.'); window.location.href='admin_dashboard.php';</script>";
            }

        } elseif ($accion === 'desafiliar') {
            // Desafiliar al usuario de cualquier plan
            if (!empty($_POST['usuario_id'])) {
                $usuario_id = intval($_POST['usuario_id']);

                $stmt = $conn->prepare("DELETE FROM afiliaciones WHERE usuario_id = ?");
                $stmt->bind_param("i", $usuario_id);
                if ($stmt->execute()) {
                    echo "<script>alert('Usuario desafiliado exitosamente.'); window.location.href='admin_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error al desafiliar al usuario: {$conn->error}'); window.location.href='admin_dashboard.php';</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Por favor, proporcione un usuario válido para desafiliar.'); window.location.href='admin_dashboard.php';</script>";
            }

        } else {
            echo "<script>alert('Acción no válida.'); window.location.href='admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('No se especificó ninguna acción.'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Método de solicitud no permitido.'); window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
