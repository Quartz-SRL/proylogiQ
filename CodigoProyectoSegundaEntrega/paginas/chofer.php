<?php
//session_start();

//if (!isset($_SESSION["user_id"]) || $_SESSION["tipoUsuario"] !== "camionero") {
  //  header("Location: ../index.php"); 
    //exit();
//}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
  <title>LogiQ - Chofer</title>
  <link rel="stylesheet" type="text/css" href="../css/styles-chofer.css">
</head>
<body>
  <header>
    <div class="logo">
      <a href="../index.php"><img src="../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../api/autenticacion/logout.php">Cerrar sesion</a></li>
      </ul>
    </nav>
  </header>
  
  <nav class="segundo-menu">
    <ul>
      <li><a href="seguimiento.php">Seguimiento de paquete</a></li>
      <li><a href="nosotros.php">Sobre nosotros</a></li>
      <li><a href="contacto.php">Contacto</a></li>
      <li><a href="preguntas.php">Preguntas Frecuetes</a></li>
    </ul>
  </nav>
  
    <div class="contenedor">
        <h2>Aplicacion de Chofer</h2>
        <div class="buttons">
      <a href="" class="btn">Ver Ruta</a>
      <a href="" class="btn">Ingresar Horarios</a>
    </div>
    </div>

  <footer class="footer">

    <div class="footer-container">
    

    <div class="cont">
    <h4>Nosotros</h4>
    <ul style="list-style: none;">
        <li><a href="">Contacto</a></li>
        <li><a href="">Sobre nosotros</a></li>
        <li><a href="">Pregutas Frecuentes</a></li>
    </ul>
    </div>
    <div class="logo">
      <img src="../img/logo.png">
        <p>2023 © - todos los derechos reservados</p>
    </div>
    <div class="social-icons">
        <h4>Siguenos</h4>
    
        <a href=""><i class="fa-brands fa-facebook"></i></a>
        <a href=""><i class="fa-brands fa-twitter"></i></a>
        <a href=""><i class="fa-brands fa-instagram"></i></a>
    
    </div>
    </div>
  </footer>
</body>
</html>