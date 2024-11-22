<?php
require_once 'conexion.php'; // Conexión a la base de datos

// Consultar los planes disponibles en la base de datos
$sql = "SELECT nombre, descripcion, precio FROM planes";
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
  <title>Afiliación</title>
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
          <li class="nav-item"><a class="nav-link active" href="../html/afiliacion.html">Afiliación</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/cartilla.html">Cartilla Médica</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/beneficios.html">Beneficios</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/index.html#contacto">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="bg-primary text-white text-center py-5">
    <div class="container">
      <h1>Afíliate a nuestra Obra Social</h1>
      <p class="lead">Explora nuestros planes y elige el que mejor se adapte a tus necesidades</p>
    </div>
  </header>

  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Planes de Afiliación</h2>
      <div class="row g-4">
        <?php foreach ($planes as $plan): ?>
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($plan['nombre']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($plan['descripcion']) ?></p>
              <p class="fw-bold">$<?= number_format($plan['precio'], 2) ?> / mes</p>
              <button class="btn btn-primary" onclick="window.location.href='../php/afiliarme.php?plan=<?= urlencode($plan['nombre']) ?>'">Más información</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-light pt-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <h5>Sobre Nosotros</h5>
                <p>Somos una obra social comprometida en ofrecer atención de calidad para todos nuestros afiliados.</p>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Inicio</a></li>
                    <li><a href="#" class="text-light">Planes</a></li>
                    <li><a href="#" class="text-light">Servicios</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contacto</h5>
                <p><strong>Teléfono:</strong> +123 456 789</p>
                <p><strong>Email:</strong> atencion@obrasocial.com</p>
                <p><strong>Dirección:</strong> Calle Salud 123, Ciudad</p>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Síguenos</h5>
                <div class="d-flex">
                    <a href="#" class="mr-3"><img src="../img/facebook-icon.png" alt="Facebook" width="30"></a>
                    <a href="#" class="mr-3"><img src="../img/instagram-icon.png" alt="Instagram" width="30"></a>
                    <a href="#"><img src="../img/x-logo.png" alt="Twitter" width="30"></a>
                </div>
            </div>
        </div>
        <div class="text-center py-3">
            <small>&copy; 2024 Obra Social. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
