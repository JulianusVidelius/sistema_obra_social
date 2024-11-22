<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../php/inicio_sesion.php");
    exit();
}

require_once '../php/conexion.php'; // Incluir conexión a la base de datos

// Obtener los planes de la base de datos
$sql = "SELECT nombre, precio FROM planes";
$result = $conn->query($sql);

// Almacenar los planes en un arreglo
$planes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $planes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Afiliarme</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="../html/index.html">Obra Social</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="../html/afiliarme.html">Afiliarme</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/cartilla.html">Cartilla Médica</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/beneficios.html">Beneficios</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/index.html#contacto">Contacto</a></li>
          <li class="nav-item"><a class="nav-link" href="../php/perfil.php">Perfil</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="bg-primary text-white text-center py-5">
    <div class="container">
      <h1>Afiliarme</h1>
      <p class="lead">Regístrate, inicia sesión y elige el plan ideal para ti</p>
    </div>
  </header>

  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Elige tu Plan</h2>
      <div class="row g-4">
        <?php foreach ($planes as $plan): ?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($plan['nombre']) ?></h5>
              <p class="card-text">Descripción genérica del plan <?= htmlspecialchars($plan['nombre']) ?>.</p>
              <p class="fw-bold">$<?= number_format($plan['precio'], 2) ?> / mes</p>
              <form action="../php/afiliar_plan.php" method="POST">
                <input type="hidden" name="plan" value="<?= htmlspecialchars($plan['nombre']) ?>">
                <button type="submit" class="btn btn-primary">Afiliarme</button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-light pt-4 mt-5">
    <div class="container">
      <div class="text-center py-3">
        <small>&copy; 2024 Obra Social. Todos los derechos reservados.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
