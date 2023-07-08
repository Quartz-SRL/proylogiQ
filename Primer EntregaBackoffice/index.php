<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="styles.css">
    <title>Backoffice</title>
</head>

<body>
    <h1>Backoffice de administracion</h1>
    <div class="divContenedor">
        


        <div class="divOpciones">
            <div class="divOpcionAlta">
                
                <hr>
                <h3>Alta Usuario</h3>
                <form action="altaPersona.php" method="POST">
                    <input class="inputs" type=text name="id" placeholder="ID:">
                    <input class="inputs" type=text name="usuario" placeholder="Usuario:">
                    <input class="inputs" type=text name="contraseña" placeholder="Contraseña:">
                    
                    <select name="tipoUsuario" onchange="mostrarCamposAdicionales(this)">
                        <option value="administrador">Administrador</option>
                        <option value="empAlmacen">Empleado de Almacén</option>
                        <option value="chofer">Chofer</option>
                        <br>
                    </select>
                    <div id="camposChofer" style="display: none;">
                    <input class="inputs" type=text name="nombre" placeholder="Nombre">
                    <input class="inputs" type=text name="apellido" placeholder="Apellido">
                    <input class="inputs" type=text name="documento" placeholder="documento"> 
                    <input class="inputs" type=text name="tipoLibreta" placeholder="Tipo Libreta">
                    </div>    
                    <br>
                    <br>
                    <input class="botonAlta" type="submit" value="Agregar Persona" src="index.php">

                </form>
            </div>
            
            <div class="divModificar">     
                <hr>
                <h3>Modificar Usuario</h3>       
                <form action="buscarUsuario.php" method="GET">
                <input class="inputs" type="text" name="idUsuario" placeholder="ID del Usuario">
                <input class="botonMod" type="submit" value="Buscar">
            </form>        
            </div>
            <div class="divOpcionBaja">
                
                <hr>
                <h3>Dar de baja usuario</h3>
                <form action="bajaPersona.php" method="POST">
                    <input class="inputs" type=text name="id" placeholder="ID:">
                    <br>
                    <input class="botonBaja" type="submit" value="Dar de Baja Persona" src="index.php">
                </form>
                <hr>
            </div>
        </div>
    </div>

    
    
   <div class="lista">
    <div class="mostrarLista" style="display: block;">
  <button onclick="mostrarListaUsuarios()">Listar los Usuarios</button>
</div>
<div class="ocultarLista" style="display: none;">
  <button onclick="ocultarListaUsuarios()">Ocultar Lista</button>
</div>
  
    <div id="tablaUsuarios" style="display: none;">
    <div class="divTabla">
            <table border="2px">
                <tr>
                    <td><b><span class="extra">Id</span></b></td>
                    <td><b><span class="extra">Usuario</span></b></td>
                    <td><b><span class="extra">Contraseña</span></b></td>
                    <td><b><span class="extra">TipoUsuario</span></b></td>
                    <td><b><span class="extra">Nombre</span></b></td>
                    <td><b><span class="extra">Apellido</span></b></td>
                    <td><b><span class="extra">Documento</span></b></td>
                    <td><b><span class="extra">tipoLibreta</span></b></td>
                </tr>
                <tr>
                    <td>
                        <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                            echo $fila["id"] . "<hr>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                            echo $fila["usuario"] . "<hr>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                            echo $fila["contraseña"] . "<hr>";
                        }
                        ?>
                    </td>
                    <td>
                    <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                        echo $fila["tipoUsuario"] . "<hr>";
                    }
                    ?>
                    </td>
                    <td>
                    <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                        echo $fila["nombre"] . "<hr>";
                    }
                    ?>
                    </td>
                    <td>
                    <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                        echo $fila["apellido"] . "<hr>";
                    }
                    ?>
                    </td>
                    <td>
                    <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                        echo $fila["documento"] . "<hr>";
                    }
                    ?>
                    </td>
                    <td>
                    <?php

                        $coneccion = new mysqli("127.0.0.1", "root", "", "logiQ");
                        $instruccion = "select * from usuarios";

                        $filas = $coneccion->query($instruccion);

                        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
                        echo $fila["tipoLibreta"] . "<hr>";
                    }
                    ?>
                    </td>
                    <td>
                 
                </tr>
            </table>
        </div>
    </div>
  </div>
  </div>
    <script>
    function mostrarCamposAdicionales(selectElement) {
        var camposChofer = document.getElementById("camposChofer");

        if (selectElement.value === "chofer") {
            camposChofer.style.display = "block";
        } else {
            camposChofer.style.display = "none";
        }
    }

    function mostrarListaUsuarios() {
    var tablaUsuarios = document.getElementById("tablaUsuarios");
    var ocultarLista = document.getElementsByClassName("ocultarLista")[0];
    var mostrarLista = document.getElementsByClassName("mostrarLista")[0];

    tablaUsuarios.style.display = "block";
    ocultarLista.style.display = "block";
    mostrarLista.style.display = "none";
  }

  function ocultarListaUsuarios() {
    var tablaUsuarios = document.getElementById("tablaUsuarios");
    var ocultarLista = document.getElementsByClassName("ocultarLista")[0];
    var mostrarLista = document.getElementsByClassName("mostrarLista")[0];

    tablaUsuarios.style.display = "none";
    ocultarLista.style.display = "none";
    mostrarLista.style.display = "block";
  }

    
  </script>

</body>
</html>