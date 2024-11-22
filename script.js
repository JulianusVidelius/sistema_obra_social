document.addEventListener("DOMContentLoaded", () => {
    fetch('/php/session_check.php')
      .then(response => response.json())
      .then(data => {
        const sessionControl = document.getElementById('sessionControl');
        if (data.loggedIn) {
          sessionControl.innerHTML = `
            <a href="/php/perfil.php" class="btn btn-outline-dark">${data.userRole === 'admin' ? 'Panel Admin' : 'Mi Perfil'}</a>
            <button class="btn btn-outline-danger" onclick="logout()">Cerrar Sesión</button>
          `;
        } else {
          sessionControl.innerHTML = `
            <button class="btn btn-outline-dark" onclick="redirectToLogin()">Iniciar Sesión</button>
          `;
        }
      });
  });
  
  function redirectToLogin() {
    window.location.href = "inicio_sesion.html";
  }
  
  function logout() {
    fetch('/php/cerrar_sesion.php')
      .then(() => location.reload());
  }
  if (data.userRole === 'admin') {
    document.querySelectorAll('.admin-only').forEach(item => {
      item.style.display = 'block';
    });
  }
  if (data.loggedIn) {
    document.getElementById('welcomeMessage').textContent = `Bienvenido, ${data.userName}`;
  }