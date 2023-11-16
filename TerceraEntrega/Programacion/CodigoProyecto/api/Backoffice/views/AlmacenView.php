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
    <h1>Gestion de Almacen</h1>
    
    <div id="contenedor">
        <div class="izquierda">
            <h3>Alta Almacen</h3>
            <form id="almacenForm"  action="">
               
                <input class="inputs" type=text name="direccion" placeholder="Direccion:">
                <input class="inputs" type=text name="ciudad" placeholder="Ciudad:">
                <input class="inputs" type=text name="departamento" placeholder="Departamento:">
                <input class="inputs" type=text name="cantEntradas" placeholder="Cantidad entradas:">
                <input class="inputs" type=text name="codigoVerificacion" placeholder="Codigo verificador:">
                <input class="inputs" type=text name="telefono" placeholder="Telefono:">
                <input class="inputs" type=text name="email" placeholder="Email:">
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
                    <td>Ciudad</td>
                    <td>Departamento</td>
                    <td>Cantidad Entradas</td>
                    <td>Telefono</td>
                    <td>Email</td>
                    <td>Firma</td>
                    <td>Accion</td>
                </tr>

                <?php
    include(__DIR__ . '/../controllers/AlmacenController.php');
    $controlador = new almacenController();
    $almacenesJSON = $controlador->obtenerAlmacen();
    $almacenes = json_decode($almacenesJSON, true);


    foreach ($almacenes as $almacen) {
            
            echo "<tr id='fila-almacen-{$almacen['idAlmacen']}'>";
            echo "<td>{$almacen['idAlmacen']}</td>";
            echo "<td>{$almacen['direccion']} </td>";
            echo "<td>{$almacen['ciudad']}</td>";
            echo "<td>{$almacen['departamento']}</td>";
            echo "<td>{$almacen['cantEntradasParaCamion']}</td>";
            echo "<td>{$almacen['telefono']}</td>";
            echo "<td>{$almacen['email']}</td>";
            echo "<td>{$almacen['firma']}</td>";
            echo "<td><button onclick=\"eliminarAlmacen({$almacen['idAlmacen']})\">Eliminar almacen</button>
                 <a href='ModificarAlmacenView.php?almacen_modificar={$almacen['idAlmacen']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        }
    
    echo "</table>";
    ?>



            </table>
        </div>
        
    </div>

  

    <script>
        function eliminarAlmacen(Id) {
            if (confirm('¿Estás seguro de eliminar este almacen?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/AlmacenController.php', 
                    data: { almacen_eliminar: Id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Almacen eliminado  correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el Almacen.');
                        }
                    },
                    error: function() {
                        alert('Hubo un error al eliminar el Almacen. No puede eliminar un almacen con vehiculos asignados');
                    }
                });
            }
        }
        
        function ingresarAlmacen(){
            var formDat = $('#almacenForm').serialize();
            $.ajax({
                url: '../controllers/AlmacenController.php',
                type: 'POST',
                data: formDat,
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