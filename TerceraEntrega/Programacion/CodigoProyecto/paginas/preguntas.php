<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    <script src="../js/script-login.js"></script>
    <title>Preguntas Frecuentes - LogiQ</title>
    <link rel="stylesheet" type="text/css" href="../css/styles-preguntas.css">
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
  
  <div class="contenedor-preguntas">
    <h2>Preguntas Frecuentes</h2>
    <div class="pregunta">
      <h3>¿Cuál es el tiempo estimado de entrega?</h3>
      <p>El tiempo estimado de entrega varía según la ubicación y el tipo de envío. Generalmente, 
        los envíos nacionales demoran de 2 a 5 días hábiles. En el transcurso de la entrega puedes hacer un seguimiento de tu paquete
      saber en que estado se encuentra.</p>
    </div>
    <div class="pregunta">
      <h3>¿Cómo puedo realizar un seguimiento de mi paquete?</h3>
      <p>Para realizar un seguimiento de tu paquete, puedes ingresar el código de 
        seguimiento en el formulario de seguimiento en nuestra página principal. 
        Una vez ingresado el código, podrás ver la ubicación y el estado actual de tu paquete.</p>
    </div>
    <div class="pregunta">
      <h3>¿Qué hago si mi paquete no ha llegado?</h3>
      <p>Si tu paquete no ha llegado dentro del tiempo estimado de entrega, te 
        recomendamos contactar a nuestro servicio de atención al cliente. Ellos 
        podrán brindarte información actualizada sobre el estado de tu paquete y 
        resolver cualquier problema.</p>
    </div>
    <div class="pregunta">
      <h3>¿Cómo puedo cambiar la dirección de entrega?</h3>
      <p>Si necesitas cambiar la dirección de entrega de tu paquete, te recomendamos 
        comunicarte con nuestro servicio de atención al cliente lo antes posible. 
        Ellos podrán verificar si es posible realizar el cambio y brindarte instrucciones adicionales.</p>
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