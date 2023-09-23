<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
  <title>LogiQ</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <header>
    <div class="logo">
      <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="#" onclick="mostrarLoginForm()">Iniciar sesion</a></li> <!-- llama a la funcion para abrir la ventana de login-->
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
      <form>
        <input type="text" placeholder="Ingrese el código del paquete">
        <button type="submit">Rastrear</button>
      </form>
  </div>

  <div class="modal-overlay" id="modalOverlay">
    <div class="modal-contenido">
      <span class="boton-cerrar" onclick="cerrarLoginForm()">&times;</span>    <!-- llama a la funcion para cerrar el menu emergente-->
        <h2>Iniciar sesión</h2>
        <?php include("api/autenticacion/controller/controllerLogin.php");?>
    <form action="" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" ><br><br>
            
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasenia" ><br><br>
            
            <input type="submit" name="btnIngresar" value="Iniciar sesión">
        </form>
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
<script>
  /* Funcion que muestra el login*/
  function mostrarLoginForm() {
      var modalOverlay = document.getElementById("modalOverlay");
      modalOverlay.classList.add("show");
  }
  /* Funcion que oculta el login*/
  function cerrarLoginForm() {
            var modalOverlay = document.getElementById("modalOverlay");
            modalOverlay.classList.remove("show");
        }
</script>


</html>
