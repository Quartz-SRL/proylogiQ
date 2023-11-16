<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["tipoUsuario"] !== "administrador") {
    header("Location: ../index.php"); 
    exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="../img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
  <title>LogiQ - Backoffice</title>
  <link rel="stylesheet" type="text/css" href="../css/styles-backoffice.css">
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
        <h2>Aplicacion de Backoffice</h2>
        <div class="buttons">
          <a href="../api/Backoffice/views/UsuarioView.php" class="btn">Gestión de Usuarios</a>
          <a href="../api/Backoffice/views/AlmacenView.php" class="btn">Gestión de almacenes</a>
          <a href="../api/Backoffice/views/VehiculosView.php" class="btn">Gestión de vehículos</a>
          <a href="../api/Backoffice/views/PaqueteView.php" class="btn">Gestión de paquetes</a>
          <a href="../api/Backoffice/views/LotesView.php" class="btn">Gestión de lotes</a>
          <a href="../api/Backoffice/views/agregarTrayectoView.php" class="btn">Agregar Trayectos</a>
          
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
        <h4>Siguenos</h4>
    
        <a href=""><i class="fa-brands fa-facebook"></i></a>
        <a href=""><i class="fa-brands fa-twitter"></i></a>
        <a href=""><i class="fa-brands fa-instagram"></i></a>
    
    </div>
    </div>
  </footer>
</body>
</html>