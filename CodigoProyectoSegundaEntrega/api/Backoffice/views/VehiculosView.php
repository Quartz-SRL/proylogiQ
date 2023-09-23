<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta name="keywords" content="">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../../css/styles-gestion.css">

    <title>Backoffice</title>
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

    <h1>Administracion de vehiculos</h1>
    <div id="contenedor">
      
            <div class="izquierda">
                <h3>Alta vehiculo</h3>
                <form id="altaForm" action="" method="POST">
                    <input class="inputs" type=text name="matricula" placeholder="Matricula:">
                    <input class="inputs" type=text name="pesoMax" placeholder="Peso maximo:">
                    <select name="estado" id="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>

                    <select name="tipoVehiculo" onchange="mostrarCamposAdicionales(this)">
                        <option value="ligero">Ligero</option>
                        <option value="pesado">Pesado</option>
                        <br>
                    </select>
                    <div id="camposPesado" style="display: none;">
                        <input class="inputs" type=text name="tipoCamion" placeholder="TipoCamion">
                        <input class="inputs" type=text name="tamanoCaja" placeholder="Tamaño de caja">   
                    </div style="display: none;">
                    <input type="hidden" name="alta" value="alta">
                    <input class="botonAlta" name="btnAltaVehiculo" id="btnAlta" type="submit" value="Agregar vehiculo"
                        onclick="agregarVehiculo()">

                </form>

            </div>

            <div class="derecha">
            <table>
                <tr>
                    <td>Matricula</td>
                    <td>Peso Maximo</td>
                    <td>estado</td>
                    <td>Tamaño caja</td>
                    <td>Tipo Vehiculo</td>
                    <td>Accion</td>
                    
                </tr>

                <?php
    include(__DIR__ . '/../controllers/VehiculosController.php');
    $controlador = new vehiculoController();
    $vehiculosJSON = $controlador->obtenerVehiculos();
    $vehiculos = json_decode($vehiculosJSON, true);
    foreach ($vehiculos as $vehiculo) {
        
            $hayVehiculos = true;
            
            echo "<tr id='fila-vehiculo-{$vehiculo['matricula']}'>";
            echo "<td>{$vehiculo['matricula']}</td>";
            echo "<td>{$vehiculo['pesoMax']}</td>";
            echo "<td>{$vehiculo['estado']}</td>";
            echo "<td>{$vehiculo['tamanoCaja']}</td>";
            echo "<td>{$vehiculo['tipoCamion']}</td>";
            echo "<td><button onclick=\"eliminarVehiculo({$vehiculo['matricula']})\">Eliminar vehículo</button>
                 <a href='ModificarVehiculosView.php?matricula_modificar={$vehiculo['matricula']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        }
    
    if (!$hayVehiculos) {
        echo "No hay vehiculos para mostrar.";
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
        function mostrarCamposAdicionales(selectElement) {
            var camposPesado= document.getElementById("camposPesado");
 
            if (selectElement.value === "pesado") {
                camposPesado.style.display = "block";
                
            } else {
                camposPesado.style.display = "none";
                
            }
        }

        function agregarVehiculo() {
            var formData = $('#altaForm').serialize();
            $.ajax({
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/VehiculosController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Vehículo ingresado correctamente");
                   }else{
                    alert("error al ingresar el paquete");
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor")
                }
            });
                }
        
        function eliminarVehiculo(matricula) {
            if (confirm('¿Estás seguro de eliminar este vehiculo?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/codigoProyecto/api/backoffice/controllers/VehiculosController.php', 
                    data: { vehiculo_eliminar: matricula },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Vehiculo eliminado correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el vehiculo');
                        }
                    },
                    error: function() {
                        alert('Hubo un error al comunicarse con el servidor.');
                    }
                });
            }
        }                
    </script>

</body>

</html>