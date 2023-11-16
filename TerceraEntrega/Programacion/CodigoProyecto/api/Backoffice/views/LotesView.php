<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-gestion.css">
    <title>Lotes</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div class="logo">
      <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../../../paginas/backoffice.php">Volver a Backofice</a></li> 
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>

    <h1>Gestion de Lotes</h1>
    
    <div id="contenedor">

        <div class="izquierda">
            <h3>Alta Lotes</h3>
            <form id="lotesForm"  action="">
                
                <input class="inputs" type=text name="pesoLote" placeholder="Peso:">
                
                <select name="idAlmacen">
                     <?php
                        include(__DIR__ . '/../controllers/AlmacenController.php');
                        $controlador = new almacenController();
                        $almacenesJSON = $controlador->obtenerAlmacen();
                        $almacenes = json_decode($almacenesJSON, true);

                         foreach ($almacenes as $almacen) {
                         echo '<option value="' . $almacen['idAlmacen'] . '">' . $almacen['idAlmacen'] . " "."-"." " . $almacen['departamento'] . '</option>';
                          }
                      ?>
                    </select>
                
                <input type="hidden" name="lotesForm" value="lotesForm" >
                <input type="submit" value="ingresarLote" id="btnAlta" onclick="ingresarLotes()">
            </form>
    </div>

        <div class="derecha">
            <table>
                <tr>
                    <th>Id</th>
                    <th>peso</th>
                    <th>Destino</th>
                    <th>Fecha Ingreso</th>
                    <th>Acción</th>
                </tr>

                <?php
    include(__DIR__ . '/../controllers/lotesController.php');
    $controlador = new loteController();
    $lotesJSON = $controlador->obtenerLotes();
    $lotes = json_decode($lotesJSON, true);

   
    foreach ($lotes as $lote) {
       
            
            echo "<tr id='fila-lote-{$lote['idLote']}'>";
            echo "<td>{$lote['idLote']}</td>";
            echo "<td>{$lote['pesoLote']}</td>";
            echo "<td>Almacen {$lote['idAlmacen']}</td>";
            echo "<td>{$lote['fechaIngresoLote']}</td>";
            echo "<td><button onclick=\"eliminarLote({$lote['idLote']})\">Eliminar lote</button>
                 <a href='ModificarLotesView.php?idLote_modificar={$lote['idLote']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        } 
    ?>



            </table>
        </div>
    </div>

  

    <script>
        function eliminarLote(loteId) {
            if (confirm('¿Estás seguro de eliminar este lote?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/LotesController.php', 
                    data: { lotes_eliminar: loteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('lote eliminado  correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el paquete .');
                        }
                    },
                    error: function() {
                        alert('El lote no debe tener ningun paquete asignado para poder ser eliminado.');
                    }
                });
            }
        }
        
        function ingresarLotes(){
            var formData = $('#lotesForm').serialize();
            $.ajax({
                url: '../controllers/LotesController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Lote ingresado correctamente");
                   }else{
                    alert("error al ingresar el Lote");
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor")
                }
            });
        }
        

        
    </script>
</body>
</html>