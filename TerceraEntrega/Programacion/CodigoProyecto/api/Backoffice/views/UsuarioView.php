<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="../../../css/styles-gestion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

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
    <h1>Administracion de usuarios</h1>
    <div id="contenedor">

            <div class="izquierda">

                
                <h3>Alta Usuario</h3>
                <form id="altaForm" action="" >
                    
                    <input class="inputs" type="text" name="usuario" placeholder="Usuario:">
                    <input class="inputs" type="text" name="contraseña" placeholder="Contraseña:">
                    <select name="tipoUsuario" onchange="mostrarCamposAdicionales(this)">
                        <option value="administrador">Administrador</option>
                        <option value="empAlmacen">Empleado de Almacén</option>
                        <option value="camionero">Chofer-Camionero</option>
                        <option value="transportista">Chofer-Repartidor</option>
                    </select>
                    <div id="camposChofer" style="display: none;">
                        <input class="inputs" type="text" name="nombre" placeholder="Nombre">
                        <input class="inputs" type="text" name="apellido" placeholder="Apellido">
                        <input class="inputs" type="text" name="documento" placeholder="Documento">
                        <br>
                        <label for="enServicio">En Servicio</label>
                       
                        <input class="inputs" type="checkbox" name="enServicio" id="enServicio" value="si">
                    </div>
                    <div id="camposCamionero" style="display: none;">
                        <input class="inputs" type="text" name="tipoLibreta" placeholder="Tipo Libreta">
                    </div>
                    <input type="hidden" name="altaForm" value="alta">
                    <input name="btnAlta" type="submit" id="btnAlta" value="Agregar usuario" onclick="agregarUsuario()">
                </form>
            </div>
            <div class="derecha">
            <table>
        <tr>
            <th>Id Usuario</th>
            <th>Usuario</th>
            <th>Tipo de Usuario</th>
            <th>Acción</th>
        </tr>
        <?php

        include (__DIR__ . '/../controllers/UsuarioController.php');

        $controlador = new UsuarioController();
        $usuariosJSON = $controlador->obtenerUsuarios();
        $usuarios = json_decode($usuariosJSON, true); 
        
        foreach ($usuarios as $usuario) {
            echo "<tr id='fila-usuario-{$usuario['id']}'>";
            echo "<td>{$usuario['id']}</td>";
            echo "<td>{$usuario['usuario']}</td>";
            echo "<td>{$usuario['tipoUsuario']}</td>";
            echo "<td><button onclick=\"eliminarUsuario('{$usuario['id']}')\">Eliminar Usuario</button>
            <a href='ModificarUsuarioView.php?idUsuarioModificar={$usuario['id']}'><button>Modificar Usuario</button></a></td>";
            echo "</tr>";
        }
        
        ?>

    </table>
            </div>

    </div>

   
    <script>
        function mostrarCamposAdicionales(selectElement) {
            var camposChofer = document.getElementById("camposChofer");
            var camposCamionero = document.getElementById("camposCamionero");

            if (selectElement.value === "transportista") {
                camposChofer.style.display = "block";
                camposCamionero.style.display = "none";
            } else if (selectElement.value === "camionero") {
                camposChofer.style.display = "block";
                camposCamionero.style.display = "block";
            } else {
                camposChofer.style.display = "none";
                camposCamionero.style.display = "none";
            }
        }

        function agregarUsuario(){
            var formData = $('#altaForm').serialize();
            $.ajax({
                url: '../controllers/UsuarioController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("Usuario ingresado correctamente");
                   }else{
                    alert("error al ingresar el usuario");
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor")
                }
                
            });
            
        }

        function eliminarUsuario(id){
            let idUsuario = id;
            if(confirm("Estas seguro que deseas eliminar al usuario "+ idUsuario)){
            $.ajax({
                url: '../controllers/UsuarioController.php',
                type: 'POST',
                data: {idUsuarioEliminar : idUsuario},
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    location.reload();
                    alert("usuario eliminado correctamente");
                   }else{
                    alert("error al eliminar el usuario");
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor");
                }
            
            });

            }
        }
    </script>

</body>

</html>