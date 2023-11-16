<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    <script src="../js/script-login.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles-seguimiento.css">
    <link rel="stylesheet" type="text/css" href="../css/styles-modal.css">
    <title>LogiQ - Seguimiento</title>
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
  
  <?php
    include("../api/seguimiento/controllers/seguimientoController.php");
    $controller= new SeguimientoController();
    if(isset($_POST["codigoPaquete"])){
      
      $codigoPaquete=$_POST["codigoPaquete"];
      $estadoPaqueteJson=$controller->estadoPaquete($codigoPaquete);
      $estadoPaquete=json_decode($estadoPaqueteJson, true);
      
      foreach($estadoPaquete as $estado){
        if(isset($estado["estado"]) && $estado["estado"] == "en almacen principal QC"){
        ?>
        <div class="contenedor">
          <h2>Rastrear mi paquete</h2>
          <form method="POST" action=""> 
            <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
            <button type="submit">Rastrear</button>
          </form>
          <div class="contenedor-seguimiento">
            <h3>Información del paquete</h3>
            <p><strong>Estado:</strong><?php echo $estado['estado']; ?></p>
            <p><strong>Demora estimada:</strong>El paquete sera entregado dentro de las siguientes 48hs</p>
          </div>
        </div>
        <?php
      } elseif((isset($estado["estado"]) && isset($estado["matricula"])&& $estado["estado"]=="en transito")) {
        ?>
        <div class="contenedor">
          <h2>Rastrear mi paquete</h2>
          <form method="POST" action=""> 
            <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
            <button type="submit">Rastrear</button>
          </form>
          <div class="contenedor-seguimiento">
            <h3>Información del paquete</h3>
            <p><strong>Estado:</strong><?php echo $estado['estado']; ?></p>
            <p><strong>Número de lote:</strong><?php echo $estado['idLote']; ?></p>
            <p><strong>Camión que lo transporta:</strong><?php echo $estado['matricula']; ?></p>
            <p><strong>Demora estimada al almacén de destino:</strong><?php echo $estado['tiempoAlmCentral']; ?>hs</p>
            <p>*Luego de llegar al almacén de destino, la entrega se realizará dentro de las 24hs siguientes*</p>
          </div>
        </div>
        <?php
      } elseif(isset($estado["estado"]) && $estado["estado"] == "en almacen destino"){

        ?>
        <div class="contenedor">
          <h2>Rastrear mi paquete</h2>
          <form method="POST" action=""> 
            <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
            <button type="submit">Rastrear</button>
          </form>
          <div class="contenedor-seguimiento">
            <h3>Información del paquete</h3>
            <p><strong>Estado:</strong><?php echo $estado['estado']; ?></p>
            <p><strong>Demora estimada:</strong>El paquete llegó al almacén de destino, será entregado a su puerta dentro de las proximas 24hs.</p>
          </div>
        </div>
        <?php

      }elseif(isset($estado["estado"]) && $estado["estado"] == "entregado"){
        ?>
        <div class="contenedor">
          <h2>Rastrear mi paquete</h2>
          <form method="POST" action=""> 
            <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
            <button type="submit">Rastrear</button>
          </form>
          <div class="contenedor-seguimiento">
            <h3>Información del paquete #<?php echo $estado['codigoPaquete']?>.</h3>
            <p><strong>El paquete fue entregado correctamente en su destino.<br>Cualquier otra consulta puede comunicarce con QuickCarry en la seccion de contacto.</strong></p>
          </div>
        </div>
        <?php
      }else {
        ?>
        <div class="contenedor">
          <h2>Rastrear mi paquete</h2>
          <form method="POST" action=""> 
            <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
            <button type="submit">Rastrear</button>
          </form>
          <div class="contenedor-seguimiento">
            <h3>Información del paquete</h3>
            <p><strong>Código inexistente, ingréselo de nuevo.</strong></p>
          </div>
        </div>
        <?php
      }
    }
  } else {
    ?>
    <div class="contenedor">
      <h2>Rastrear mi paquete</h2>
      <form method="POST" action="">
        <input type="text" name="codigoPaquete" placeholder="Ingrese el código del artículo">
        <button type="submit">Rastrear</button>
      </form>
    </div>
    <?php
  }
  ?>
  <div class="modal-overlay" id="modalOverlay">
    <div class="modal-contenido">
      <span class="boton-cerrar" onclick="cerrarLoginForm()">&times;</span>    
      <h2>Iniciar sesión</h2>
      <?php include("../api/autenticacion/controller/controllerLogin.php");
      ?>
      <form action="" method="post">
        <div class="input-contenedor">
          <label for="usuario">Usuario:</label>
          <input type="text" id="usuario" name="usuario" ><br><br>
        </div>  
        <div class="input-contenedor">
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
