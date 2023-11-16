<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Vehiculo</title>
    <link rel="stylesheet" type="text/css" href="../../../css/styles-miVehiculo.css">
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
    <h2>Mi vehiculo</h2>

    <div id="infoVehiculo">
        <h3>Detalles del vehiculo</h3>
        <?php
            include(__DIR__ . '/../controllers/transitoController.php');
            $controlador=new TransitoController(); 
            $vehiculosJSON=$controlador->obtenerVehiculo();
            $vehiculos=json_decode($vehiculosJSON,true);
            
            foreach($vehiculos as $vehiculo){ 
            
                if(isset($vehiculo['tipoCamion'])){
            ?>
          
            <p><strong>Matricula: </strong><?php echo $vehiculo['matricula'];?></p>
            <p><strong>Estado: </strong><?php echo $vehiculo['estado'];?></p>
            <p><strong>Modelo: </strong><?php echo $vehiculo['tipoCamion'];?></p>
            <p><strong>Carga máxima: </strong> <?php echo $vehiculo['pesoMax'];?>kg</p>
        <?php 
            }else{
                ?>
                <p><strong>Matricula: </strong><?php echo $vehiculo['matricula'];?></p>
            <p><strong>Estado: </strong><?php echo $vehiculo['estado'];?></p>
            <p><strong>Carga máxima: </strong><?php echo $vehiculo['pesoMax'];?></p>
                <?php
            }
        }
        ?>
        <a href="../../../paginas/chofer.php"><button class="btnVolver">Volver</button></a>
    </div>
</body>
</html>