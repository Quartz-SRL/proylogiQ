<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-gestion.css">
    <title>Paquetes</title>
    
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

    <h1>Gestion de Paquetes</h2>
    
    <div id="contenedor">
        <div class="izquierda">
            <form id="paquetesForm"  action="">
                <input class="inputs" type=text name="codigo" placeholder="Codigo:">
                <input class="inputs" type=text name="peso" placeholder="Peso:">
                <input class="inputs" type=text name="categoria" placeholder="Categoria:">
                <select name="fragil">
                <option value="fragil">Fragil</option>
                <option value="noFragil">No fragil</option>
                </select>
                <input class="inputs" type=text name="calle" placeholder="Calle:">
                <input class="inputs" type=text name="numero" placeholder="Numero">
                <input class="inputs" type=text name="ciudad" placeholder="Ciudad:">
                <input class="inputs" type=text name="departamento" placeholder="Departamento:">
                <input class="inputs" type=text name="emailDestino" placeholder="Email Destinatario:">
                <input class="inputs" type=text name="telDestino" placeholder="Telefono Destinatario:">
                <input class="inputs" type=text name="fechaIngreso" placeholder="Fecha de ingreso:">
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
    include(__DIR__ . '/../controllers/PaqueteController.php');
    $controlador = new paqueteController();
    $paquetesJSON = $controlador->obtenerPaquetes();
    $paquetes = json_decode($paquetesJSON, true);

    $hayPaquetes = false;
    foreach ($paquetes as $paquete) {
        if ($paquete['idLote'] === null) {
            $hayPaquetes = true;
            
            echo "<tr id='fila-paquete-{$paquete['codigo']}'>";
            echo "<td>{$paquete['codigo']}</td>";
            echo "<td>{$paquete['peso']}</td>";
            echo "<td>{$paquete['categoria']}</td>";
            echo "<td>{$paquete['fragil']}</td>";
            echo "<td>{$paquete['calle']} {$paquete['numero']}</td>";
            echo "<td>{$paquete['ciudad']}</td>";
            echo "<td>{$paquete['departamento']}</td>";
            echo "<td>{$paquete['emailDestino']}</td>";
            echo "<td>{$paquete['fechaIngreso']}</td>";
            echo "<td><button onclick=\"eliminarPaquete({$paquete['codigo']})\">Eliminar paquete</button>
                 <a href='ModificarPaqueteView.php?codigo_modificar={$paquete['codigo']}'><button>Editar datos</button></a></td>";
            echo "</tr>";
            
        }
    }
    echo "</table>";
    if (!$hayPaquetes) {
        echo "No hay paquetes para mostrar.";
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
        function eliminarPaquete(paqueteId) {
            if (confirm('¿Estás seguro de eliminar este paquete?')) {
                
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/codigoProyecto/api/backoffice/controllers/PaqueteController.php', 
                    data: { paquete_eliminar: paqueteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Paquete eliminado  correctamente.');
                            location.reload();
                        } else {
                            alert('Hubo un error al eliminar el paquete .');
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
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/PaqueteController.php',
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