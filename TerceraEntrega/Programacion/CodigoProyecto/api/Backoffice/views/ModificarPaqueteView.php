<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-modificar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Modificar paquete</title>
</head>
<body><div id="modificarDiv">
    <h2>Modificar Paquete</h2>


        <?php
        include (__DIR__ . '/../controllers/PaqueteController.php');
        $controlador=new paqueteController();
        if(isset($_GET['codigo_modificar'])){
            $codigo = $_GET['codigo_modificar'];
            $paquete = $controlador->obtenerPaquetePorCodigo($codigo);
            
        } ?>

  
            <form id="modificarPaquetesForm" action='../views/PaqueteView.php'>
            <label for="codigo">Codigo</label>
                <input class="inputs" type=text name="codigo" value=<?php echo $paquete['codigoPaquete']; ?>>
                <label for="peso">Peso</label>
                <input class="inputs" type=text name="peso" value="<?php echo $paquete['pesoPaquete']; ?>">
                <label for="categoria">Categoria</label>
                <input class="inputs" type=text name="categoria" value="<?php echo $paquete['categoria']; ?>">
                <label for="fragil">Fragil</label>
                <select name="fragil">
                <option value="fragil">Fragil</option>
                <option value="noFragil">No fragil</option>
                </select>
                <label for="direccion">Direccion</label>
                <input class="inputs" type=text name="direccion" value="<?php echo $paquete['direccion']; ?>">
                <label for="ciudad">Ciudad</label>    
                <input class="inputs" type=text name="ciudad" value="<?php echo $paquete['ciudad']; ?>">
                <label for="departamento">departamento</label>
                <input class="inputs" type=text name="departamento" value="<?php echo $paquete['departamento']; ?>">
                <label for="emailDestino">Email Destinatario</label>   
                <input class="inputs" type=text name="emailDestino" value="<?php echo $paquete['emailDestinatario']; ?>">
                <label for="telDestino">Telefono</label>
                <input class="inputs" type=text name="telDestino" value="<?php echo $paquete['telDestinatario']; ?>">
                <label for="fechaIngreso">Fechade ingreso</label>
                <input class="inputs" type=text name="fechaIngreso" value="<?php echo $paquete['fechaIngreso']; ?>">
                <input type="hidden" name="modificarPaquetesForm" value="modPaqueteForm" >
                <input type="submit" value="modificarPaquete" id="btnAlta" onclick="modPaquete()">
            </form>
            <a href="PaqueteView.php"><button class="button">Cancelar</button></a>
    </div>

    <script>
        function modPaquete(){
            var formData = $('#modificarPaquetesForm').serialize();
            $.ajax({
                url: '../controllers/PaqueteController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("paquete modificado correctamente");
                    
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