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
        <li><a href="../../../paginas/backoffice.php">Volver a Backoffice</a></li> 
      </ul>
    </nav>
  </header>
  <div class="header-line"></div>
  <div id="modificarDiv">
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
            <form id="modificarAlmacenForm" action='../views/AlmacenView.php'>
                <label for="id">id</label>
                <input class="inputs" type=text name="id" value=<?php echo $almacen['idAlmacen']; ?>>
                
                <label for="calle">direccion</label>
                <input class="inputs" type=text name="direccion" value="<?php echo $almacen['direccion']; ?>">
                
                <label for="departamento">departamento</label>
                <input class="inputs" type=text name="departamento" value="<?php echo $almacen['departamento']; ?>">
                <label>cantidad de entradas</label>   
                <input class="inputs" type=text name="cantEntradas" value="<?php echo $almacen['cantEntradasParaCamion']; ?>">
               
                <label for="">Telefono</label>
                <input class="inputs" type=text name="telefono" value="<?php echo $almacen['telefono']; ?>">
                <label for="">Email</label>
                <input class="inputs" type=text name="email" value="<?php echo $almacen['email']; ?>">
                <label for="">Firma</label>
                <input class="inputs" type=text name="Firma" value="<?php echo $almacen['firma']; ?>">
                
                <input type="hidden" name="modificarAlmacenForm" value="modAlmacenForm" >
                <input type="submit" class="button"value="modificar" id="" onclick="modAlmacen()">
            </form>
            <a href="AlmacenView.php"><button class="button">Cancelar</button></a>
        </div>
    </div>


    <script>
        function modAlmacen(){
            var formData = $('#modificarAlmacenForm').serialize();
            $.ajax({
                url: '../controllers/AlmacenController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Almacen modificado correctamente");
                    
                   }else{
                    alert("error al modificar el Almacen");
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