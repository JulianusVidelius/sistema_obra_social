# Proyecto Sistema Obra Social

Este proyecto implementa un sistema de login básico con un usuario administrador creado automáticamente si no existe. Está desarrollado en PHP, HTML, CSS, JS y utiliza MySQL para la gestión de usuarios.

## Documentación del Sistema

### Descripción General

El sistema permite el registro e inicio de sesión de usuarios. Si no existe un usuario administrador en la base de datos (con el correo `admin@example.com`), el sistema lo creará automáticamente con una contraseña encriptada.

#### Componentes:

- **conexion.php**: Establece la conexión con la base de datos MySQL.
- **procesar_login.php**: Maneja la lógica de inicio de sesión y la creación del usuario administrador.
- **inicio_sesion.html**: Formulario de inicio de sesión de usuario.
- **Base de Datos**: Se utiliza una base de datos MySQL con la tabla `usuarios`.

### Requisitos

- PHP 7.x o superior.
- MySQL o MariaDB para la base de datos.
- Servidor web (Apache o Nginx).
- Acceso a la base de datos y privilegios para insertar datos.

## Instrucciones de Instalación

### 1. Crear la Base de Datos

Primero, crea la base de datos en MySQL o MariaDB, y luego la tabla `usuarios` con la siguiente estructura:

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    apellido VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    contrasena VARCHAR(255),
    rol VARCHAR(50)
);
```
# Instrucciones de Uso

### 1. Formulario de Inicio de Sesión
Accede al archivo `inicio_sesion.html` donde podrás ingresar tu correo electrónico y contraseña.

### 2. Verificación de Usuario
Si el correo electrónico y la contraseña son correctos, el sistema iniciará sesión y redirigirá al usuario a su página correspondiente:

- Si el rol es `admin`, se redirige a `admin_dashboard.php`.
- Si el rol es diferente, se redirige a `perfil.php`.

### 3. Creación del Usuario Admin
Si no existe el usuario administrador con el correo `admin@example.com`, se creará automáticamente al intentar iniciar sesión.

## Posibles Mejoras

- **Soporte para más roles**: Actualmente, solo se define el rol de `admin`. Se podría ampliar para permitir la creación de roles adicionales (por ejemplo, `usuario`, `moderador`).
- **Recuperación de Contraseña**: Agregar una funcionalidad de recuperación de contraseña para los usuarios que olviden su contraseña.
- **Autenticación Multi-Factor (MFA)**: Implementar un sistema de autenticación de dos factores para mejorar la seguridad.
- **Interfaz de Usuario Mejorada**: Mejorar el diseño de la interfaz de inicio de sesión y las páginas de perfil.
- **Logs de Seguridad**: Agregar un sistema de logs para registrar los intentos de inicio de sesión y otros eventos importantes para la seguridad.

## Informe de Pruebas Realizadas

### 1. Pruebas de Inicio de Sesión:

- **Caso 1**: Iniciar sesión con un usuario que existe en la base de datos.
  - **Resultado esperado**: Redirección correcta a la página de perfil o dashboard del administrador.
  - **Resultado obtenido**: La prueba fue exitosa, el sistema redirige correctamente.

- **Caso 2**: Iniciar sesión con un usuario que no existe en la base de datos.
  - **Resultado esperado**: El sistema debe mostrar un mensaje de error que indique que el correo no está registrado.
  - **Resultado obtenido**: La prueba fue exitosa, se muestra el mensaje adecuado.

- **Caso 3**: Iniciar sesión con una contraseña incorrecta.
  - **Resultado esperado**: El sistema debe mostrar un mensaje que indique que la contraseña es incorrecta.
  - **Resultado obtenido**: La prueba fue exitosa, se muestra el mensaje adecuado.

- **Caso 4**: Intentar crear un usuario admin si ya existe uno con el mismo correo.
  - **Resultado esperado**: El sistema debe comprobar si el usuario `admin@example.com` existe y evitar duplicados.
  - **Resultado obtenido**: La prueba fue exitosa, el sistema previene la creación del usuario duplicado.

### 2. Pruebas de Seguridad:

- **Prueba 1**: Verificar que la contraseña esté correctamente encriptada.
  - **Resultado esperado**: La contraseña debe estar almacenada de manera segura utilizando `password_hash`.
  - **Resultado obtenido**: La prueba fue exitosa, la contraseña está correctamente encriptada en la base de datos.

- **Prueba 2**: Comprobar la seguridad del inicio de sesión.
  - **Resultado esperado**: La función `password_verify` debe validar correctamente las contraseñas y proteger contra ataques de diccionario.
  - **Resultado obtenido**: La prueba fue exitosa, la validación funciona correctamente.

- **Prueba 3**: Verificar la protección contra ataques SQL Injection.
  - **Resultado esperado**: El sistema debe ser resistente a los ataques SQL Injection mediante el uso de consultas preparadas (`prepare` y `bind_param`).
  - **Resultado obtenido**: La prueba fue exitosa, el sistema está protegido contra SQL Injection.

## Seguridad Implementada

- **Contraseñas encriptadas**: Las contraseñas se almacenan de manera segura usando `password_hash` para encriptar las contraseñas antes de almacenarlas en la base de datos. Para la verificación, se usa `password_verify` para comparar la contraseña ingresada con la almacenada.
- **Protección contra SQL Injection**: Se utilizan consultas preparadas (`prepare` y `bind_param`) para evitar ataques de inyección SQL, lo que asegura que los datos ingresados por el usuario no alteren las consultas a la base de datos.
- **Sesiones seguras**: Se utiliza `session_start` para gestionar las sesiones de los usuarios de manera segura y almacenar la información de sesión en variables globales.


### Creditos 
 Pablo Almada, Julian Vidal e Ivo Mignone
