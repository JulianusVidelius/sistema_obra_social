<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Función para obtener todos los planes
function obtenerPlanes($conn) {
    $sql = "SELECT * FROM planes";
    return $conn->query($sql);
}

// Función para obtener todos los usuarios
function obtenerUsuarios($conn) {
    $sql = "SELECT u.id, u.nombre, u.apellido, u.email, a.plan FROM usuarios u 
            LEFT JOIN afiliaciones a ON u.id = a.usuario_id";
    return $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Panel de Administración</h1>

        <!-- Gestión de Planes -->
        <section class="mt-4">
            <h2>Gestión de Planes</h2>
            <form action="procesar_planes.php" method="POST" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del Plan" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio del Plan" required>
                    </div>
                    <div class="col-md-4">
                        <textarea name="descripcion" class="form-control" placeholder="Descripción del Plan" rows="1" required></textarea>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar Plan</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Plan</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $planes = obtenerPlanes($conn);
                    while ($plan = $planes->fetch_assoc()): ?>
                        <tr>
                            <td><?= $plan['id'] ?></td>
                            <td><?= $plan['nombre'] ?></td>
                            <td><?= $plan['precio'] ?></td>
                            <td><?= $plan['descripcion'] ?></td>
                            <td>
                                <form action="procesar_planes.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $plan['id'] ?>">
                                    <button type="submit" name="accion" value="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Gestión de Usuarios -->
        <section class="mt-5">
            <h2>Gestión de Usuarios</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Plan Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usuarios = obtenerUsuarios($conn);
                    while ($usuario = $usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= $usuario['nombre'] . ' ' . $usuario['apellido'] ?></td>
                            <td><?= $usuario['email'] ?></td>
                            <td><?= $usuario['plan'] ?? 'Sin afiliación' ?></td>
                            <td>
                                <form action="procesar_usuarios.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                                    <select name="plan" class="form-select form-select-sm" required>
                                        <option value="">Seleccionar Plan</option>
                                        <?php
                                        $planes = obtenerPlanes($conn);
                                        while ($plan = $planes->fetch_assoc()): ?>
                                            <option value="<?= $plan['nombre'] ?>"><?= $plan['nombre'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <button type="submit" name="accion" value="asignar" class="btn btn-primary btn-sm">Asignar</button>
                                    <button type="submit" name="accion" value="desafiliar" class="btn btn-warning btn-sm">Desafiliar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
