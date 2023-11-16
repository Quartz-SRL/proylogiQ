<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/styles-transito.css">
    <title>Ruta recomendada</title>
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
    <div class="almacenes-container">
        <?php
        include(__DIR__ . '/../controllers/transitoController.php');
        $controlador = new TransitoController();
        $almacenesJson = $controlador->asignarTrayecto();
        $almacenes = json_decode($almacenesJson, true);
        $a=0;
        if (empty($almacenes)) {
            echo '<p>No hay lotes para entregar en ningún almacén.</p>';
        } else {
        foreach ($almacenes as $almacen) {
            $a++;
        ?>
        <div class="almacen-card">
            <h2><?php echo 'Destino ' . $a . ' almacen de ' .  $almacen['ciudad'];  ?>
            </h2>
            <p><strong>Tiempo aproximado hasta el destino: </strong><?php echo $almacen['tiempoAlmCentral'];?>hrs. </p>
            <p><strong>Direccion:</strong> <?php echo $almacen['direccion']; ?></p>
            <p><strong>Departamento: </strong><?php echo $almacen['departamento']; ?></p>
            <p><strong>Cantidad de lotes destinado aqui: </strong><?php echo $almacen['cantidadLotes']; ?></p>
            <a href='verLotesDescargar.php?id_Almacen=<?php echo $almacen["idAlmacen"]?>'><button>Lotes a descargar</button></a>
        </div>
        <?php }} ?>
    </div>  
            <div id="div-btn">
            <a href="../../../paginas/chofer.php"><button class="button">Volver</button></a>
            </div>
    <script>
        function entregado(idAlmacen){
            console.log("Función entregado llamada con idAlmacen: " + idAlmacen);
            if (confirm('¿Desea dar como realizada esta entrega?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/transitoController.php', 
                    data: { idAlmacen: idAlmacen },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Entrega Realizada.');
                            location.reload();
                        } else {
                            alert('Hubo un error al realizar la entrega.');
                        }
                    },
                    error: function() {
                        alert('Hubo un error .');
                    }
                });
            }
        }
    </script>
</body>
</html>
