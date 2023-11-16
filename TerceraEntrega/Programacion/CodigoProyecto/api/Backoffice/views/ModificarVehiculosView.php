<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-modificar.css">
    <title>Modificar Vehiculos</title>
</head>

<body>
<div id="modificarDiv">
    <h3>Modificar vehiculo</h3>

    <?php
        include (__DIR__ . '/../controllers/VehiculosController.php');
        $controlador=new vehiculoController();
        if(isset($_GET['matricula_modificar'])){
            $matricula = $_GET['matricula_modificar'];
            $vehiculoEncontrado = $controlador->obtenerVehiculoPorMatricula($matricula);
            
        } ?>
    <form id="modVehiculo"action="vehiculosview.php" method="POST">
        <input class="inputs"type="text" name="matricula" value="<?php echo $vehiculoEncontrado['matricula']; ?>">
        <input class="inputs" type=text name="pesoMax" value="<?php echo $vehiculoEncontrado['pesoMax']; ?>">
        <input class="inputs" type=text name="estado" value="<?php echo $vehiculoEncontrado['estado']; ?>">
        
        <?php if (array_key_exists('tipoCamion', $vehiculoEncontrado)) { ?>
            <input class="inputs" type="text" name="tipoCamion" value="<?php echo $vehiculoEncontrado['tipoCamion']; ?>">
            <input class="inputs" type="text" name="tamanoCaja" value="<?php echo $vehiculoEncontrado['cantidadLotesCaja']; ?>">
         <?php } ?>
         <input type="hidden" name="modVehiculo" value="modVehiculo">
        <input type="submit" name="btnModificarVehiculo" id="btnAlta" value="Modificar" onclick="modVehiculo()">
    </form>

    <a href="VehiculosView.php"><button class="button">Cancelar</button></a>

    </div>
    <script>
        function modVehiculo() {
            var formData = $('#modVehiculo').serialize();
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
    </script>
</body>

</html>