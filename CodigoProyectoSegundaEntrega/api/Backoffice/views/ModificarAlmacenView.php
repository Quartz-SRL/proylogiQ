<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-modificar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Modificar almacen</title>
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
  
    <h2>Modificar almacen</h2>
    <div>

        <?php
        include (__DIR__ . '/../controllers/AlmacenController.php');
        $controlador=new almacenController();
        if(isset($_GET['almacen_modificar'])){
            $id = $_GET['almacen_modificar'];
            $almacen = $controlador->obtenerAlmacenPorId($id);
            
        } ?>

        <div>
            <form id="modAlmacenForm" action='http://localhost/codigoProyecto/api/Backoffice/views/AlmacenView.php'>
                <label for="id">id</label>
                <input class="inputs" type=text name="id" value=<?php echo $almacen['id']; ?>>
                <label for="">numero</label>
                <input class="inputs" type=text name="numero" value="<?php echo $almacen['numero']; ?>">
                <label for="">km</label>
                <input class="inputs" type=text name="km" value="<?php echo $almacen['km']; ?>">
                <label for="calle">Calle</label>
                <input class="inputs" type=text name="calle" value="<?php echo $almacen['calle']; ?>">
                <label for="ciudad">Ciudad</label>    
                <input class="inputs" type=text name="ciudad" value="<?php echo $almacen['ciudad']; ?>">
                <label for="departamento">departamento</label>
                <input class="inputs" type=text name="departamento" value="<?php echo $almacen['departamento']; ?>">
                <label>cantidad de entradas</label>   
                <input class="inputs" type=text name="cantEntradas" value="<?php echo $almacen['cantEntradas']; ?>">
                <label for="">Ciudades que Cubre</label>
                <input class="inputs" type=text name="ciudadesCubre" value="<?php echo $almacen['ciudadesCubre']; ?>">
                <label for="">Firma</label>
                <input class="inputs" type=text name="Firma" value="<?php echo $almacen['Firma']; ?>">
                
                <input type="hidden" name="modificarAlmacenForm" value="modificarAlmacenForm" >
                <input type="submit" value="modificar" id="" onclick="modAlmacen()">
            </form>
            <a href="AlmacenView.php"><button class="button">Cancelar</button></a>
        </div>
        
    </div>

    <script>
        function modAlmacen(){
            var formData = $('#modificarAlmacenForm').serialize();
            $.ajax({
                type: 'POST',
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/AlmacenController.php',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Almacen modificado correctamente");
                    
                   }else{
                    alert("error al modificar el paquete");
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