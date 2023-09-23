<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-gestion.css">
    <title>Almacen</title>
    
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
    <h2>Gestion de Almacen</h2>
    
    <div id="contenedor">
        <div class="izquierda">
            <form id="almacenForm"  action="">
                <input class="inputs" type=text name="id" placeholder="Id:">
                <input class="inputs" type=text name="calle" placeholder="Calle:">
                <input class="inputs" type=text name="numero" placeholder="Numero">
                <input class="inputs" type=text name="km" placeholder="Km:">
                <input class="inputs" type=text name="ciudad" placeholder="Ciudad:">
                <input class="inputs" type=text name="departamento" placeholder="Departamento:">
                <input class="inputs" type=text name="cantEntradas" placeholder="Cantidad entradas:">
                <input class="inputs" type=text name="codigoVerificacion" placeholder="Codifo verificador:">
                <input class="inputs" type=text name="ciudadesCubre" placeholder="Ciudades que cubre:">
                <input class="inputs" type=text name="Firma" placeholder="Firma:">
                <input type="hidden" name="almacenForm" value="almacenForm" >
                <input type="submit" value="ingresarAlmacen" id="btnAlta" onclick="ingresarAlmacen()">
            </form>
    </div>

        <div class="derecha">
            <table>
                <tr>
                    <td>Id</td>
                    <td>Direccion</td>
                    <td>Km</td>
                    <td>Ciudad</td>
                    <td>Departamento</td>
                    <td>Cantidad Entradas</td>
                    <td>Ciudades que cubre</td>
                    <td>Firma</td>
                    <td>Accion</td>
                </tr>

                <?php
    include(__DIR__ . '/../controllers/AlmacenController.php');
    $controlador = new almacenController();
    $almacenesJSON = $controlador->obtenerAlmacen();
    $almacenes = json_decode($almacenesJSON, true);


    foreach ($almacenes as $almacen) {
            
            echo "<tr id='fila-almacen-{$almacen['id']}'>";
            echo "<td>{$almacen['id']}</td>";
            echo "<td>{$almacen['calle']} {$almacen['numero']}</td>";
            echo "<td>{$almacen['km']}</td>";
            echo "<td>{$almacen['ciudad']}</td>";
            echo "<td>{$almacen['departamento']}</td>";
            echo "<td>{$almacen['cantEntradas']}</td>";
            echo "<td>{$almacen['ciudadesCubre']}</td>";
            echo "<td>{$almacen['Firma']}</td>";
            echo "<td><button onclick=\"eliminarAlmacen({$almacen['id']})\">Eliminar almacen</button>
                 <a href='ModificarAlmacenView.php?almacen_modificar={$almacen['id']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        }
    
    echo "</table>";
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
        function eliminarAlmacen(Id) {
            if (confirm('¿Estás seguro de eliminar este almacen?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/codigoProyecto/api/backoffice/controllers/AlmacenController.php', 
                    data: { almacen_eliminar: Id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Almacen eliminado  correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el Almacen .');
                        }
                    },
                    error: function() {
                        alert('Hubo un error al comunicarse con el servidor.');
                    }
                });
            }
        }
        
        function ingresarAlmacen(){
            var formData = $('#almacenForm').serialize();
            $.ajax({
                type: 'POST',
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/AlmacenController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Almacen ingresado correctamente");
                   }else{
                    alert("error al ingresar el Almacen");
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