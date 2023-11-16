<?php
require(__DIR__ . "/../model/conexion.php");
//session_start();

if (!empty($_POST["btnIngresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["contrasenia"])) {
        $usuario = $_POST["usuario"];
        $contrasenia = $_POST["contrasenia"];
        
       
       
        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario';";
        $resultado = mysqli_query($conexion, $query);
        if ($resultado && mysqli_num_rows($resultado) == 1) {
            $row = mysqli_fetch_assoc($resultado);
            
           
            if (password_verify($contrasenia,$row["contrasena"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["usuario"] = $row["usuario"];
                $_SESSION["tipoUsuario"] = $row["tipoUsuario"];
                
                if ($row["tipoUsuario"] == "administrador") {
                    header("Location: paginas/backoffice.php");
                } elseif ($row["tipoUsuario"] == "camionero") {
                    header("Location: api/transito/views/camionero.php");
                } elseif($row['tipoUsuario']=="empAlmacen"){
                    header("Location: paginas/almacen.php");
                }elseif($row["tipoUsuario"] == "transportista"){
                    header("Location: api/transito/views/camionero.php");
                }
            } else {
                echo'Usuario y/o contraseña incorrectas';
               
            }
        } else {
            $_SESSION['login_error'] = 'Usuario y/o contraseña incorrectos';
            echo "Usuario y/o contraseña incorrectas";
            
        }

        

        

        mysqli_close($conexion);
    }
}

    //si es mandado desde otra pagina que no sea index

    if (!empty($_POST["btnIngresarPaginas"])) {
        if (!empty($_POST["usuario"]) && !empty($_POST["contrasenia"])) {
            $usuario = $_POST["usuario"];
            $contrasenia = $_POST["contrasenia"];
    
           
            $query = "SELECT id, usuario, tipoUsuario, contrasena FROM usuarios WHERE usuario = '$usuario';";
            $resultado = mysqli_query($conexion, $query);
            echo $query;
            if ($resultado && mysqli_num_rows($resultado) == 1) {
                $row = mysqli_fetch_assoc($resultado);
                
               
                if (password_verify($contrasenia,$row["contrasena"])) {
                    $_SESSION["user_id"] = $row["id"];
                    $_SESSION["usuario"] = $row["usuario"];
                    $_SESSION["tipoUsuario"] = $row["tipoUsuario"];
            
                    if ($row["tipoUsuario"] == "administrador") {
                        header("Location: backoffice.php");
                    } elseif ($row["tipoUsuario"] == "camionero") {
                        header("Location: ../api/transito/views/camionero.php");
                    } elseif($row['tipoUsuario']=="empAlmacen"){
                        header("Location: almacen.php");
                    }elseif($row["tipoUsuario"] == "transportista"){
                        header("Location: ../api/transito/views/camionero.php");
                    }
                } else {
                    var_dump(password_verify($contrasenia, $row["contrasena"]));
                    echo $row['contrasena'];
                    echo "Usuario y/o contraseña incorrectas";
                }
            } else {
                echo "Usuario y/o contraseña incorrectas";
            }
    
            
    
            
    
            mysqli_close($conexion);
        }
    }    
?>
