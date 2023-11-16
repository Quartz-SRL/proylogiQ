<?php
session_start();

if (isset($_POST['documento']) && isset($_POST['matricula'])) {
    $_SESSION['documento'] = $_POST['documento'];
    $_SESSION['matricula'] = $_POST['matricula'];
    
    header("Location: ../../../paginas/chofer.php");
    exit; // Asegúrate de que la redirección sea efectiva
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/styles-transito.css">
    <title>transito</title>
</head>
<body>
<header>
    <div class="logo">
      <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../../../paginas/chofer.php">Volver al menú</a></li>
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>
    <h3>Ingrese sus datos</h3>
    <form id="datosChofer" action="" method="POST">
        <label for="documento">Ingrese su numero de documento</label>
        <input class="inputs" type="text" name="documento" placeholder="Documento">
        <label for="matricula">Ingrese matricula del vehiculo asignado</label>
        <input class="inputs" type="text" name="matricula" placeholder="Matricula">
        <input type="hidden" name="datosChofer" value="datosChofer">
        <input type="submit" class="button" value="Ingresar">
    </form>
</body>
</html>
