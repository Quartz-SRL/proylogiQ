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
                <form id="altaFormVehiculo" action="">
                    <input class="inputs" type=text name="matricula" placeholder="Matricula:">
                    <input class="inputs" type=text name="pesoMax" placeholder="Peso maximo:">
                    <select name="estado" id="estado" placeholder="estado">
                        <option value="libre">Activo</option>
                        <option value="ocupado">Inactivo</option>
                    </select>

                    <select name="tipoVehiculo" onchange="mostrarCamposAdicionales(this)">
                        <option value="ligero">Ligero</option>
                        <option value="pesado">Pesado</option>
                        <br>
                    </select>
                    <div id="camposPesado" style="display: none;">
                        <select name="tipoCamion" id="">
                            <option value="C11">C11</option>
                            <option value="C12">C12</option>
                            <option value="T11-S1">T11-S1</option>
                            <option value="T11-S2">T11-S2</option>
                        </select>
                        <input class="inputs" type=text name="tamanoCaja" placeholder="Tamaño de caja">   
                    </div style="display: none;">

                    <div id="camposLigero" style="display: block;">
                       
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

                    </div>

                    <input type="hidden" name="altaFormVehiculo" value="altaFormVehiculo">
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
                    <td>Tipo Vehiculo</td>
                    <td>Tamaño caja</td>
                    
                    <td>Accion</td>
                    
                </tr>

                <?php
    include(__DIR__ . '/../controllers/VehiculosController.php');
    $controlador = new vehiculoController();
    $vehiculosJSON = $controlador->obtenerVehiculos();
    $vehiculos = json_decode($vehiculosJSON, true);
    $hayVehiculos = false;
    foreach ($vehiculos as $vehiculo) {
        $hayVehiculos = true;
            
            
            echo "<tr id='fila-vehiculo-{$vehiculo['matricula']}'>";
            echo "<td>{$vehiculo['matricula']}</td>";
            echo "<td>{$vehiculo['pesoMax']}</td>";
            echo "<td>{$vehiculo['estado']}</td>";
            if($vehiculo['tipoCamion']==null){
                echo "<td>ligero</td>";
            }else{
                echo "<td>{$vehiculo['tipoCamion']}</td>";
            }
            echo "<td>{$vehiculo['cantidadLotesCaja']}</td>";
            
            echo "<td><button onclick=\"eliminarVehiculo('{$vehiculo['matricula']}')\">Eliminar vehículo</button>
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


    <script>
        function mostrarCamposAdicionales(selectElement) {
            var camposPesado= document.getElementById("camposPesado");
 
            if (selectElement.value === "pesado") {
                camposPesado.style.display = "block";
                camposLigero.style.display = "none";
            } else {
                camposPesado.style.display = "none";
                camposLigero.style.display = "block";
            }

        }

        function agregarVehiculo() {
            var formData = $('#altaFormVehiculo').serialize();
            $.ajax({
                
                type: 'POST',
                url: '../controllers/VehiculosController.php',
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
                    url: '../controllers/VehiculosController.php', 
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