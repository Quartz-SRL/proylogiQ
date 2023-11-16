<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../css/styles-modificar.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Modificar Usuario</title>
  
</head>


<body>
<div id="modificarDiv">
  <h3>Modificar usuario</h3>

  <?php

          include (__DIR__ . '/../controllers/UsuarioController.php');
          $controlador= new UsuarioController();
          if (isset($_GET['idUsuarioModificar'])) {
            $idUsuario = $_GET['idUsuarioModificar'];
            $usuario = $controlador->buscarUsuario($idUsuario);

            if($usuario['tipoUsuario']==="camionero"){
              $chofer=$controlador->buscarCamionero($idUsuario);
             
            }elseif($usuario['tipoUsuario']==="transportista"){
              $chofer= $controlador->buscarTransportista($idUsuario);
            }
            
          ?>
    <form id="formModificar" action='../views/UsuarioView.php' >
      <label for="idUsuario">Id del usuario</label>
    <input class="inputs"type="text" name="idUsuario" value="<?php echo $usuario['id']; ?>"><br>
    <label for="usuario">Usuario</label>
    <input class="inputs" type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>"><br>
    <label for="contraseña">Contraseña</label>
    <input class="inputs"type="text" name="contraseña" value="<?php echo $usuario['contrasena']; ?>"><br>
    <label for="tipoUsuario">Tipo de Usuario</label>
    <input class="inputs"type="text" name="tipoUsuario" value="<?php echo $usuario['tipoUsuario']; ?>"><br>
    <?php if (isset($chofer)) { ?>

      <label for="nombre">Nombre</label>
      <input class="inputs"type="text" name="nombre" value="<?php echo $chofer['nombre']; ?>"><br>
      <label for="apellido">Apellido</label>
      <input class="inputs"type="text" name="apellido" value="<?php echo $chofer['apellido']; ?>"><br>
      <label for="documento">Documento</label>
      <input class="inputs"type="text" name="documento" value="<?php echo $chofer['documento']; ?>"><br>
      <?php if($usuario['tipoUsuario']==="camionero"){?>
      <label for="tipoLibreta">Tipo de Libreta</label>
      <input class="inputs"type="text" name="tipoLibreta" value="<?php echo $chofer['tipoLibreta']; ?>"><br>
    <?php }} ?>
    <input type="hidden" name="formModificar" value="modificar">
    <input type="submit" name="btnModificar" id="btnAlta" value="Modificar" onclick="modificarUsuario()">
    
  </form>
  <a href="UsuarioView.php"><button class="button">Cancelar</button></a>
  
      <?php } ?>
</div>
      <Script>
        function modificarUsuario(){
          var formDatos = $('#formModificar').serialize();
          $.ajax({
                url: '../controllers/UsuarioController.php',
                type: 'POST',
                data: formDatos,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("usuario modificado correctamente");
                    
                   }else{
                    alert("error al modificar el usuario");
                    
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor");
                }
            });
        }
      </Script>
</body>

</html>