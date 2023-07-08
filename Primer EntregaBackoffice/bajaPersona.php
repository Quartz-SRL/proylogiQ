<?php
$conexion = new mysqli("127.0.0.1","root","","logiQ");

$id = $_POST['id'];


$sentencia = "DELETE FROM usuarios
WHERE id=$id";

if($conexion->query($sentencia) === TRUE)
header("Location: /backoffice/index.php?exito=true");
else
header("Location: /backoffice/index.php?exito=false");
?>