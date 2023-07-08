<html>
    <head>
    <link rel="stylesheet" href="styles.css">
    </head>
<?php
$conexion = new mysqli("127.0.0.1", "root", "", "logiQ");

$idUsuario = $_GET['idUsuario'];

$sentencia = "SELECT * FROM usuarios WHERE id = '$idUsuario'";
$resultado = $conexion->query($sentencia);

if ($resultado->num_rows === 1) {
  $usuario = $resultado->fetch_assoc();
?>

  <form action="modificarUsuario.php" method="POST">
  <input type="hidden" name="idUsuario" value="<?php echo $usuario['id']; ?>">
    <input type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>">
    <input type="text" name="contraseña" value="<?php echo $usuario['contraseña']; ?>">
    <input type="text" name="tipoUsuario" value="<?php echo $usuario['tipoUsuario']; ?>">
    <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>">
    <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>">
    <input type="text" name="documento" value="<?php echo $usuario['documento']; ?>">
    <input type="text" name="tipoLibreta" value="<?php echo $usuario['tipoLibreta']; ?>">
    
    
    <input type="submit" value="Modificar">
  </form>

<?php
} else {
  echo "Usuario no encontrado.";
}
?>
</html>
