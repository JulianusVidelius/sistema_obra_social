<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../html/inicio_sesion.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener la información del usuario
$sql = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$sql->bind_param("i", $usuario_id);
$sql->execute();
$resultado = $sql->get_result();
$usuario = $resultado->fetch_assoc();

// Obtener el plan de afiliación del usuario, si tiene uno
$plan_sql = $conn->prepare("SELECT * FROM afiliaciones WHERE usuario_id = ?");
$plan_sql->bind_param("i", $usuario_id);
$plan_sql->execute();
$plan_resultado = $plan_sql->get_result();
$plan = $plan_resultado->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="perfil.php">Mi Perfil</a>
            <a class="navbar-brand mx-auto" href="../html/index.html">Obra Social</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../html/afiliacion.html">Afiliación</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/cartilla.html">Cartilla Médica</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/beneficios.html">Beneficios</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/index.html#contacto">Contacto</a></li>
                    <li class="nav-item"><button id="sessionBtn" class="btn btn-outline-dark">Cerrar Sesión</button></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección de perfil -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Mi Perfil</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Información Personal</h5>
                        <p><strong>Nombre:</strong> <?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></p>
                        <p><strong>Correo Electrónico:</strong> <?php echo $usuario['email']; ?></p>

                        <h5 class="card-title mt-4">Afiliación</h5>
                        <?php if ($plan): ?>
                            <p><strong>Plan Actual:</strong> <?php echo $plan['plan']; ?></p>
                            <form action="darse_baja.php" method="POST" class="mt-3">
                                <button type="submit" name="darse_baja" class="btn btn-danger">Darse de Baja</button>
                            </form>
                        <?php else: ?>
                            <p>No estás afiliado a ningún plan. <a href="afiliacion.php">Afíliate ahora</a>.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de cierre de sesión -->
    <script>
        document.getElementById('sessionBtn').addEventListener('click', function() {
            window.location.href = "cerrar_sesion.php";
        });
    </script>
</body>
</html>
