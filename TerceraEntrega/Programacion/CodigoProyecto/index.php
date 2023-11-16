<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    
    <script src="js/script-login.js"></script>
    <title>LogiQ</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles-modal.css">
</head>
<body>
  <header>
    <div class="logo">
      <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <?php
          session_start();
        
          if (isset($_SESSION['user_id']) && isset($_SESSION['usuario']) === true) {
              // si El usuario ha iniciado sesión, muestra el enlace de Cerrar sesión
              echo '<li><a href="api/autenticacion/logout.php">Cerrar sesión</a></li>';
          } else {
              // si El usuario no ha iniciado sesión, muestra el enlace de Iniciar sesión
              echo '<li><a onclick="mostrarLoginForm()">Iniciar sesión</a></li>';
          }
          ?>
      </ul>
    </nav>
  </header>
  
  <nav class="segundo-menu">
    <ul>
      <li><a href="paginas/seguimiento.php">Seguimiento de paquete</a></li>
      <li><a href="paginas/nosotros.php">Sobre nosotros</a></li>
      <li><a href="paginas/contacto.php">Contacto</a></li>
      <li><a href="paginas/preguntas.php">Preguntas Frecuetes</a></li>
    </ul>
  </nav>
  
    <div class="contenedor">
      <h2>Rastrear mi paquete</h2>
      <form id="codigoRastrear" method="POST" action="paginas/seguimiento.php">
        <input type="text" name="codigoPaquete" placeholder="Ingrese el código del paquete">
        <input type="hidden" name="codigoRastrear" value="codigoRastrear">
        <button type="submit">Rastrear</button>
      </form>
  </div>

  <div class="modal-overlay" id="modalOverlay">
    <div class="modal-contenido">
      <span class="boton-cerrar" onclick="cerrarLoginForm()">&times;</span>    
        <h2>Iniciar sesión</h2>
        <?php include("api/autenticacion/controller/controllerLogin.php");
        
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
            <div calss="input-contenedor">
            <label for="almacen">Almacen</label><br>
            <select name="almacen">
            <?php
    include(__DIR__ . '/api/Backoffice/controllers/AlmacenController.php');
    $controlador = new almacenController();
    $almacenesJSON = $controlador->obtenerAlmacen();
    $almacenes = json_decode($almacenesJSON, true);


    foreach ($almacenes as $almacen) {

     
      echo "<option value='{$almacen['idAlmacen']}'>{$almacen['idAlmacen']}-{$almacen['ciudad']}</option>";
    } 
    ?>
 </select>
            </div>    
            <input type="submit" class="button" name="btnIngresar" value="Iniciar sesión">
        </form>
    </div>
</div>

  <footer class="footer">

    <div class="footer-container">
    

    <div class="cont">
    <h4>Nosotros</h4>
    <ul >
        <li><a href="paginas/contacto.php">Contacto</a></li>
        <li><a href="paginas/nosotros.php">Sobre nosotros</a></li>
        <li><a href="paginas/preguntas.php">Pregutas Frecuentes</a></li>
    </ul>
    </div>
    <div class="logo">
          <img src="img/logo.png">
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
