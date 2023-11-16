<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    <script src="../js/script-login.js"></script>
    <title>LogiQ - Sobre nosotros</title>
    <link rel="stylesheet" type="text/css" href="../css/styles-nosotros.css">
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
      <li><a href="preguntas.php">Preguntas Frecuentes</a></li>
    </ul>
  </nav>
  
  <div class="contenedor-sobre-nosotros">
    <h2>Sobre Nosotros</h2>
    <div class="empresa-info">
      
      <div class="text-container">
        <h3>QuickCarry - Empresa de Logística</h3>
        <p>QuickCarry es una empresa de logística con sede en Uruguay. Nos especializamos en brindar soluciones de transporte y entrega eficientes y confiables a nuestros clientes. Nuestro objetivo es simplificar el proceso de envío y proporcionar un servicio excepcional a través de nuestra red de transporte.</p> 
    </div>
    <div class="image-container">
        <img src="../img/quick.jpg" alt="QuickCarry - Empresa de Logística" height="300px">
      </div> 
    </div>
    <hr>
    <div class="programa-info">
      <div class="image-container">
        <img src="../img/logoQuartz.png" alt="LogiQ - Programa de Gestión de Envíos"  height="200px">
      </div>
      <div class="text-container">
        <h3>LogiQ - Programa de Gestión de Envíos</h3>
        <p>LogiQ es un programa de gestión de envíos desarrollado por Quartz. El programa LogiQ ofrece una plataforma completa para el seguimiento y administración
             de paquetes, permitiendo a los usuarios rastrear el progreso de sus envíos 
             y obtener información en tiempo real sobre el estado de sus paquetes.</p>
        <p>En Quartz, nos enorgullece haber desarrollado LogiQ con un enfoque en la usabilidad, la eficiencia y la 
            seguridad. Nuestro equipo de expertos en desarrollo de software trabajó para garantizar que 
            LogiQ cumpla con los estándares más altos de calidad y brinde una experiencia fluida y satisfactoria para 
            nuestros clientes y usuarios finales.</p>
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
    
        <a href=""><i class="fa-brands fa-facebook"></i></a>
        <a href=""><i class="fa-brands fa-twitter"></i></a>
        <a href=""><i class="fa-brands fa-instagram"></i></a>
      
    </div>
    </div>        
  </footer>
</body>
</html>