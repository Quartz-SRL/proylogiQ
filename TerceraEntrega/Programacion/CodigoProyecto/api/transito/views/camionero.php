<?php
session_start();

if (!empty($_POST['documento']) && !empty($_POST['matricula'])) {
    $_SESSION['documento'] = $_POST['documento'];
    $_SESSION['matricula'] = $_POST['matricula'];
    
    include(__DIR__ . '/../controllers/transitoController.php');
    $controlador = new TransitoController(); 
    
    
    $asignacionExitosa = $controlador->asignarVehiculo();

    
    if ($asignacionExitosa) {

        
          echo "<script>window.location.href = '../../../paginas/chofer.php';</script>";
    } else {
        echo "<script>alert('Ha ocurrido un error durante la asignación. Por favor, inténtelo de nuevo.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>transito</title>
    <link rel="stylesheet" type="text/css" href="../../../css/styles-transito.css">
</head>
<body>
<header>
    <div class="logo">
      <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../../../index.php">Volver al inicio</a></li>
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>
    <div id="div-datos">
    <h3>Ingrese sus datos</h3>
    <form id="datosChofer" action="" method="POST">
        <label for="documento">Ingrese su numero de documento</label>
        <input class="inputs" type="text" name="documento" placeholder="Documento">
        <label for="matricula">Ingrese matricula del vehiculo asignado</label>
        <input class="inputs" type="text" name="matricula" placeholder="Matricula">
        <input type="hidden" name="datosChofer" value="datosChofer">
        <input type="submit" class="button" value="Ingresar">
    </form>
    </div>
</body>
</html>
