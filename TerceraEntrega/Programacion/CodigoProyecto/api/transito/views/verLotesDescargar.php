<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Lotes a descargar</title>

    <link rel="stylesheet" type="text/css" href="../../../css/styles-lotesDescargar.css">
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
    <?php
    if(isset($_GET)){
        $idAlmacen=$_GET['id_Almacen'];
        
    } 
    include(__DIR__ . '/../controllers/transitoController.php');
    $controlador = new TransitoController();
    $lotesJson=$controlador->lotesADescargar($idAlmacen);
    $lotes=json_decode($lotesJson,true);
    ?>

<table>
        <thead>
        <tr>
            <th>Id Lote</th>
            <th>Destino del Lote</th>
            <th>Marcar Entrega</th>
        </tr>
        </thead>
        <tbody>
          <?php          
            foreach ($lotes as $lote) { ?>
                <tr>
                    <td><?php echo $lote['idLote']; ?></td>
                    <td><?php echo "Almacen de " . $lote['destino']; ?></td>
                    <?php if($lote['estado']=='entregado'){ ?>
                    <td>Lote entregado</td>    
                   <?php }else{ ?>
                    <td><button onclick="entregado(<?php echo $lote['idLote']?>);">Marcar como entregado</button ></td>  <?php } ?>                  
                    </tr>
            <?php } ?>
         </tbody>
    </table>

    <script>
        function entregado(idLote){
            console.log("Función entregado llamada con idLote: " + idLote);
            if (confirm('¿Desea dar como realizada esta entrega?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/transitoController.php', 
                    data: { idLote_entregado: idLote },
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