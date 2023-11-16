<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Ver paquetes</title>

    <link rel="stylesheet" type="text/css" href="../../../css/styles-cargaTransportista.css">
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

<div id="div-cargaTransportista">
    <div id="div-cargados">
    <h2>Paquetes cargados</h2>
    <table>
        <thead>
        <tr>
            <th>Codigo</th>
            <th>Destino del Paquete</th>
            <th>Ver detalles</th>
            <th>Marcar Entrega</th>

        </tr>
        </thead>
        <tbody>
          <?php

            include(__DIR__ . '/../controllers/transitoController.php');
            $controlador=new TransitoController();
            $paquetesJson=$controlador->verContenidoTransportista();
            $paquetes = json_decode($paquetesJson , true);
          
            foreach ($paquetes as $paquete) { ?>
                <tr>
                    <td><?php echo $paquete['codigoPaquete']; ?></td>
                    <td><?php echo $paquete['direccion']; ?></td>
                    <td><a href="detallesPaquete.php?codigo_paquete=<?php echo $paquete['codigoPaquete']?>"><button>ver</button></a></td></td>
                    <td><button onclick="entregado('<?php echo $paquete['codigoPaquete']?>');">Marcar como entregado</button ></td>                    
                    </tr>
            <?php } ?>
         </tbody>
    </table>

            </div>
    <div id="btnMostrarEntregados">
        <button id="buttonMostrar"onclick="mostrarEntregados()" style="display: block;">Mostrar paquetes entregados</button>
    </div>            
    <div id="tablaPaquetesEntregados" style="display: none;">
    <h3>Paquetes entregados</h3>

    <button onclick="cerrarEntregados()">Cerrar</button>
    <table>
        <thead>
            <th>Codigo</th>
            <th>Destino</th>
            <th>Fecha de entrega</th>
        </thead>
        <tbody>
           <?php 

            $paquetesEntregadosJson= $controlador->paquetesEntregados();
            $paquetesEntregados=json_decode($paquetesEntregadosJson, true);
               
           foreach($paquetesEntregados as $paquetes){ ?>
            <tr>
                <td><?php echo $paquetes['codigoPaquete']?></td>
                <td><?php echo $paquetes['direccion']?></td>
                <td><?php echo $paquetes['fechaEntregaPaquete']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    </div>
    <script>
        function entregado(codigoPaquete){
            console.log("Función entregado llamada con idLote: " + codigoPaquete);
            if (confirm('¿Desea dar como realizada esta entrega?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/transitoController.php', 
                    data: { codigoPaquete_entregado: codigoPaquete },
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
        var tablaPaquetesEntregados = document.getElementById("tablaPaquetesEntregados");
        tablaPaquetesEntregados.style.display = "block";
        var boton= document.getElementById("buttonMostrar");
        boton.style.display="none";
    }

    function cerrarEntregados() {
        var tablaPaquetesEntregados = document.getElementById("tablaPaquetesEntregados");
        var boton= document.getElementById("buttonMostrar");
        tablaPaquetesEntregados.style.display = "none";
        boton.style.display="block";
    }
    </script>

</body>
</html>