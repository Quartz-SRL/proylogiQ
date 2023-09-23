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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles-modificar.css">
    <title>Modificar paquete</title>
</head>
<body>
    <h1>Modificar Paquete</h1>
    <div>

        <?php
        include (__DIR__ . '/../controllers/controlador.php');
        $controlador=new Controlador();
        if(isset($_GET['codigo_modificar'])){
            $codigo = $_GET['codigo_modificar'];
            $paquete = $controlador->obtenerPaquetePorCodigo($codigo);
            
        } ?>

        <div class="modificarDiv">
            <form id="modificarPaquetesForm" action="vistaGestionPaquetes.php">
                <label for="codigo">Codigo</label>
                <input class="inputs" type=text name="codigo" value=<?php echo $paquete['codigo']; ?>>
                <label for="peso">Peso</label>
                <input class="inputs" type=text name="peso" value="<?php echo $paquete['peso']; ?>">
                <label for="categoria">Categoria</label>
                <input class="inputs" type=text name="categoria" value="<?php echo $paquete['categoria']; ?>">
                <label for="fragil">Fragil</label>
                <select name="fragil">
                <option value="fragil">Fragil</option>
                <option value="noFragil">No fragil</option>
                </select>
                <label for="calle">Calle</label>
                <input class="inputs" type=text name="calle" value="<?php echo $paquete['calle']; ?>">
                <label for="numero">Numero</label>   
                <input class="inputs" type=text name="numero" value="<?php echo $paquete['numero']; ?>">
                <label for="ciudad">Ciudad</label>    
                <input class="inputs" type=text name="ciudad" value="<?php echo $paquete['ciudad']; ?>">
                <label for="departamento">departamento</label>
                <input class="inputs" type=text name="departamento" value="<?php echo $paquete['departamento']; ?>">
                <label for="emailDestino">Email Destinatario</label>   
                <input class="inputs" type=text name="emailDestino" value="<?php echo $paquete['emailDestino']; ?>">
                <label for="telDestino">Telefono</label>
                <input class="inputs" type=text name="telDestino" value="<?php echo $paquete['telDestino']; ?>">
                <label for="fechaIngreso">Fechade ingreso</label>
                <input class="inputs" type=text name="fechaIngreso" value="<?php echo $paquete['fechaIngreso']; ?>">
                <input type="hidden" name="modificarPaquetesForm" value="modPaqueteForm" >
                <input type="submit" value="modificarPaquete" id="btnAlta" onclick="modPaquete()">
            </form>
        </div>
        
    </div>

    <script>
        function modPaquete(){
            var formData = $('#modificarPaquetesForm').serialize();
            $.ajax({
                url: 'http://localhost/codigoProyecto/api/almacen/controllers/controlador.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("paquete ingresado correctamente");
                    ;
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