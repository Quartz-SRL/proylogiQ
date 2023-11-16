<?php
session_start();

if (!isset($_SESSION["user_id"]) || ($_SESSION["tipoUsuario"] !== "camionero" && $_SESSION["tipoUsuario"] !== "transportista")) {
    header("Location: ../index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="imag/favicon.png" href="/img/favicon.png">
    <script src="https://kit.fontawesome.com/2ef44c27da.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <?php
    if($_SESSION["tipoUsuario"]=="camionero"){
      ?>
      
    <div class="contenedor">
        <h2>Aplicacion de Chofer</h2>
        <div class="buttons">
      <a href="../api/transito/views/verTrayectoView.php" class="btn">Ver ruta</a>
      <a href="../api/transito/views/verCarga.php" class="btn">Ver lotes cargados</a>
      <a href="../api/transito/views/miVehiculo.php" class="btn">Mi vehiculo</a>
      <a href="#" class="btn" id="concluirRecorrido">Concluir el recorrido</a>
    </div>
    </div>
    <?php
    }else{ ?>
      <div class="contenedor">
        <h2>Aplicacion de Chofer</h2>
        <div class="buttons">
      <a href="../api/transito/views/verCargaTransportista.php" class="btn">Ver paquetes cargados</a>
      <a href="../api/transito/views/miVehiculo.php" class="btn">Mi vehiculo</a>
      <a href="#" class="btn" id="concluirRecorrido">Concluir el recorrido</a>
    </div>
    </div>
    <?php
    }
    ?>
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

  <script>
$(document).ready(function() {
    $("#concluirRecorrido").click(function() {
        $.ajax({
            type: "POST",
            url: "../api/transito/controllers/transitoController.php",
            data: { action: "concluir_recorrido" },
            dataType: 'json', // Espera una respuesta en formato JSON
            success: function(response) {
                if (response && response.success) {
                    alert("Recorrido concluido con éxito");
                        window.location.href = "../index.php";
                    
                } else {
                    alert("Error al concluir el recorrido. Respuesta del servidor no válida.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error de conexión al concluir el recorrido: " + textStatus + " - " + errorThrown);
            }
        });
    });
});

</script>

</body>
</html>