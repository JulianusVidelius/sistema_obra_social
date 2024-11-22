<?php
session_start();

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al inicio de sesión
header("Location: ../html/inicio_sesion.html");
exit();
?>