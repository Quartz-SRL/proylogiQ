<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../css/styles-verCarga.css">
    <title>Ver lotes</title>
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

    <div id="div-carga">
        <div id="cargados">
    <h2>Lotes cargados</h2>
    <?php
     include(__DIR__ . '/../controllers/transitoController.php');
     $controlador=new TransitoController();
     $lotesJson=$controlador->verContenido();
     $lotes = json_decode($lotesJson , true);
    if (empty($lotes)) {
        echo '<p>No hay lotes cargados.</p>';
    } else {
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
                    <td><?php echo "Almacen de " . $lote['departamento']; ?></td>
                    <td><button onclick="entregado(<?php echo $lote['idLote']?>);">Marcar como entregado</button ></td>                    
                    </tr>
            <?php }} ?>
         </tbody>
    </table>
    </div>                      
    
        <button id="buttonMostrar" onclick="mostrarEntregados()">Mostrar lotes entregados</button>
                
    <div id="tablaEntregados" style="display: none;">
    <h3>Lotes entregados</h3>

    <button onclick="cerrarEntregados()">Cerrar</button>
    <table>
        <thead>
            <th>Id Lote</th>
            <th>Destino del lote</th>
            <th>Fecha de entrega</th>
        </thead>
        <tbody>
           <?php 
           
            $lotesEntregadosJson= $controlador->lotesEntregados();
            $lotesEntregados=json_decode($lotesEntregadosJson, true);
            
           foreach($lotesEntregados as $lote){ ?>
            <tr>
                <td><?php echo $lote['idLote']?></td>
                <td><?php echo "Almacen de " . $lote['departamento']?></td>
                <td><?php echo $lote['fechaFinTrayecto']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    </div>
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

        function mostrarEntregados() {
        var tablaEntregados = document.getElementById("tablaEntregados");
        tablaEntregados.style.display = "block";
        var boton= document.getElementById("buttonMostrar");
        boton.style.display="none";
    }

    function cerrarEntregados() {
        var tablaEntregados = document.getElementById("tablaEntregados");
        tablaEntregados.style.display = "none";
        var boton= document.getElementById("buttonMostrar");
        boton.style.display="block";
    }
    </script>

</body>
</html>