<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["tipoUsuario"] !== "empAlmacen") {
    
    header("Location: ../index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paquetes</title>
    <link rel="stylesheet" href="styles-gestion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
<header>
    <div class="logo">
      <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
    </div>
    <nav class="primer-menu">
      <ul>
        <li><a href="#">Idioma</a></li>
        <li><a href="../../../paginas/almacen.php">Volver a Almacen</a></li> 
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>

    <h1>Gestion de Paquetes</h1>
    <div id="contenedor">
    <div class="izquierda">
        
            <form id="paquetesForm"  action="">
                <input class="inputs" type=text name="codigo" placeholder="Codigo:">
                <input class="inputs" type=text name="peso" placeholder="Peso:">
                <label for="">Categoria</label>
                <select name="categoria" id="categoria">
    
                <option value="electronico">Electrónico</option>
                <option value="salud y belleza">Salud y Belleza</option>
                <option value="comestible">Comestible</option>
                <option value="moda">Moda</option>
                <option value="hogar">Hogar</option>
                <option value="entretenimiento">Entretenimiento</option>
                <option value="automocion">Automoción</option>
                <option value="otro">Otro</option>
                </select>

                <select name="fragil">
                <option value="fragil">Fragil</option>
                <option value="no Fragil">No fragil</option>
                </select>
                
                <input class="inputs" type=text name="calle" placeholder="Direccion:">
                
                <input class="inputs" type=text name="ciudad" placeholder="Ciudad:">
                <input class="inputs" type=text name="departamento" placeholder="Departamento:">
                <input class="inputs" type=text name="emailDestino" placeholder="Email Destinatario:">
                <input class="inputs" type=text name="telDestino" placeholder="Telefono Destinatario:">
                <input type="hidden" name="paquetesForm" value="paquetesForm" >
                <input type="submit" value="ingresarPaquete" id="btnAlta" onclick="ingresarPaquete()">
            </form>
   
</div>

        <div class="derecha">
            <table>
                <tr>
                    <td>Codigo</td>
                    <td>Peso</td>
                    <td>Categoria</td>
                    <td>Fragil</td>
                    <td>Direccion</td>
                    <td>Ciudad</td>
                    <td>Departamento</td>
                    <td>Email</td>
                    <td>FechaIngreso</td>
                    <td>Accion</td>
                </tr>

                <?php
    include(__DIR__ . '/../controllers/controlador.php');
    $controlador = new Controlador();
    $paquetesJSON = $controlador->obtenerPaquetes();
    $paquetes = json_decode($paquetesJSON, true);

    //$hayPaquetes = false;
    foreach ($paquetes as $paquete) {
        //if ($paquete['idLote'] === null) {
            //$hayPaquetes = true;
            
            echo "<tr id='fila-paquete-{$paquete['codigoPaquete']}'>";
            echo "<td>{$paquete['codigoPaquete']}</td>";
            echo "<td>{$paquete['pesoPaquete']}</td>";
            echo "<td>{$paquete['categoria']}</td>";
            echo "<td>{$paquete['fragil']}</td>";
            echo "<td>{$paquete['direccion']}</td>";
            echo "<td>{$paquete['ciudad']}</td>";
            echo "<td>{$paquete['departamento']}</td>";
            echo "<td>{$paquete['emailDestinatario']}</td>";
            echo "<td>{$paquete['fechaIngreso']}</td>";
            echo "<td><button onclick=\"eliminarPaquete({$paquete['codigoPaquete']})\">Eliminar paquete</button>
                 <a href='vistaModificarPaquete.php?codigo_modificar={$paquete['codigoPaquete']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        }
   // }
    echo "</table>";
    //if (!$hayPaquetes) {
     //   echo "No hay paquetes para mostrar.";
   // }
    ?>



            </table>
        </div>
        </div>
   
    <script>
        function eliminarPaquete(paqueteId) {
            if (confirm('¿Estás seguro de eliminar este paquete?')) {
                
                $.ajax({
                    type: 'POST',
                    url: '../controllers/controlador.php', 
                    data: { paquete_eliminar: paqueteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Paquete eliminado correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el paquete.');
                        }
                    },
                    error: function() {
                        alert('Hubo un error al comunicarse con el servidor.');
                    }
                });
            }
        }
        
        function ingresarPaquete(){
            var formData = $('#paquetesForm').serialize();
            $.ajax({
                url: '../controllers/controlador.php',
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