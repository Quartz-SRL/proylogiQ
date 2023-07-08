
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    

<?php
$conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

$idUsuario = $_POST['idUsuario'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
$tipoUsuario = $_POST['tipoUsuario'];
$tipoLibreta = $_POST['tipoLibreta'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$documento = $_POST['documento'];

$sentencia = "UPDATE usuarios 
            SET usuario = '$usuario', 
            documento = '$documento',
            contraseña = '$contraseña', 
            tipoUsuario = '$tipoUsuario',
            nombre = '$nombre',
            apellido = '$apellido',
            tipoLibreta = '$tipoLibreta'  
            WHERE id = '$idUsuario'";

if ($conexion->query($sentencia) === TRUE) {
  
  header("Location: /backoffice/index.php?exito=true");
} else {
  header("Location: /backoffice/index.php?exito=false");
}
?>

</body>
</html>