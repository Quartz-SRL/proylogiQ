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
            <form id="lotesForm"  action="">
                <input class="inputs" type=text name="idLote" placeholder="Id:">
                <input class="inputs" type=text name="pesoLote" placeholder="Peso:">
                <input class="inputs" type=text name="destino" placeholder="Destino:">
                <input class="inputs" type=text name="fechaIngresoLote" placeholder="Fecha ingreso:">
                
                <input type="hidden" name="lotesForm" value="lotesForm" >
                <input type="submit" value="ingresarLote" id="btnAlta" onclick="ingresarLotes()">
            </form>
    </div>

        <div calss="derecha">
            <table>
                <tr>
                    <td>Id</td>
                    <td>peso</td>
                    <td>Destino</td>
                    <td>Fecha Ingreso</td>
                    
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
            echo "<td>{$lote['destino']}</td>";
            echo "<td>{$lote['fechaIngresoLote']}</td>";
            echo "<td><button onclick=\"eliminarLote({$lote['idLote']})\">Eliminar lote</button>
                 <a href='ModificarLotesView.php?idLote_modificar={$lote['idLote']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        } 
    ?>



            </table>
        </div>
    </div>

    <footer class="footer">

    <div class="footer-container">

    <div class="logo">
        <img src="../../../img/logo.png">
         <p>2023 © - todos los derechos reservados</p>
    </div>

</div>        
</footer>

    <script>
        function eliminarLote(loteId) {
            if (confirm('¿Estás seguro de eliminar este lote?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/codigoProyecto/api/backoffice/controllers/LotesController.php', 
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
                        alert('Hubo un error, el lote no debe tener ningun paquete asignado para poder ser eliminado.');
                    }
                });
            }
        }
        
        function ingresarLotes(){
            var formData = $('#lotesForm').serialize();
            $.ajax({
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/LotesController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("paquete ingresado correctamente");
                   }else{
                    alert("error al ingresar el paquete");
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