<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    <script src="../js/script-login.js"></script>
    <title>LogiQ - Contacto</title>
    <link rel="stylesheet" type="text/css" href="../css/styles-contacto.css">
    <link rel="stylesheet" type="text/css" href="../css/styles-modal.css">
</head>
<body>
  <header>
    <div class="logo">
      <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <?php
          session_start();

          if (isset($_SESSION['user_id']) && isset($_SESSION['usuario']) === true) {
              // El usuario ha iniciado sesión, muestra el enlace de Cerrar sesión
              echo '<li><a href="../api/autenticacion/logout.php">Cerrar sesión</a></li>';
          } else {
              // El usuario no ha iniciado sesión, muestra el enlace de Iniciar sesión
              echo '<li><a onclick="mostrarLoginForm()">Iniciar sesión</a></li>';
          }
          ?>
      </ul>
    </nav>
  </header>
  
  <nav class="segundo-menu">
    <ul>
      <li><a href="seguimiento.php">Seguimiento de paquete</a></li>
      <li><a href="nosotros.php">Sobre nosotros</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="preguntas.php">Preguntas frecuentes</a></li>
    </ul>
  </nav>
  
  <div class="contenedor">
    <h2>Contacto</h2>
    <div class="contenido">
      <div class="informacion-contacto">
        <h3>Información de contacto</h3>
        <p><strong>Teléfono:</strong> +598 12345678</p>
        <p><strong>Email:</strong> info@quickcarry.com</p>
        <p><strong>Dirección:</strong> Av. Principal 123, Montevideo, Uruguay</p>
      </div>
      <div class="formulario-contacto">
        <h3>Formulario de contacto</h3>
        <form>
          <input type="text" name="nombre" placeholder="Nombre">
          <input type="email" name="email" placeholder="Email">
          <textarea name="mensaje" placeholder="Mensaje"></textarea>
          <input type="submit" value="Enviar">
        </form>
      </div>
    </div>
  </div>

  <div class="modal-overlay" id="modalOverlay">
    <div class="modal-contenido">
      <span class="boton-cerrar" onclick="cerrarLoginForm()">&times;</span>    
        <h2>Iniciar sesión</h2>
        <?php include("../api/autenticacion/controller/controllerLogin.php");
        
        ?>
    <form action="" method="post">
          <div calss="input-contenedor">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" ><br><br>
            
        </div>  
        <div calss="input-contenedor">
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasenia" ><br><br>
            </div>  
            <input type="submit" class="button" name="btnIngresarPaginas" value="Iniciar sesión">
        </form>
    </div>
</div>

  <footer class="footer">
    <div class="footer-container">
      <div class="cont">
        <h4>Nosotros</h4>
        <ul style="list-style: none;">
        <li><a href="contacto.php">Contacto</a></li>
          <li><a href="nosotros.php">Sobre nosotros</a></li>
          <li><a href="preguntas.php">Preguntas Frecuentes</a></li>
        </ul>
      </div>
      <div class="logo">
        <img src="../img/logo.png">
        <p>2023 © - todos los derechos reservados</p>
      </div>
      <div class="social-icons">
        <h4>Síguenos</h4>
        <a href=""><i class="fab fa-facebook"></i></a>
        <a href=""><i class="fab fa-twitter"></i></a>
        <a href=""><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </footer>
</body>
</html>
