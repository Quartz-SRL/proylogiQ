<?php
$conexion = new mysqli("127.0.0.1","root","","logiQ");

$id = $_POST['id'];
$usuario = $_POST['usuario'];

$contraseña = $_POST['contraseña'];
$tipoUsuario = $_POST['tipoUsuario'];



if ($tipoUsuario === "chofer") {
    $tipoLibreta = $_POST['tipoLibreta'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];

    $sentencia = "INSERT INTO usuarios VALUES ('$id', '$usuario', '$contraseña', '$tipoUsuario','$nombre', '$apellido', '$documento', '$tipoLibreta')";
} else {
    $tipoLibreta = null;
    $nombre = null;
    $apellido = null;
    $documento = null;
    $sentencia = "INSERT INTO usuarios VALUES ('$id', '$usuario', '$contraseña', '$tipoUsuario','$nombre', '$apellido', '$documento', '$tipoLibreta')";
}


if($conexion->query($sentencia) === TRUE)
header("Location: /backoffice/index.php?exito=true");
else
header("Location: /backoffice/index.php?exito=false");
?>