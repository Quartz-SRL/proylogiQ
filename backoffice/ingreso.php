<?php
// Datos de conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bdlogiq";

// Crear conexión
$conn = new mysqli("127.0.0.1", "root", "", "bdlogiq");

// Verificar la conexión
if (!$conn) {
    echo "hoola";
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir los datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$tipo = $_POST['tipo'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$documento = $_POST['documento'];
$tipo_libreta = $_POST['tipo_libreta'];

// Encriptar la contraseña
$contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

// Crear la consulta SQL para insertar los datos
$sql = "INSERT INTO empleados (usuario, contrasena, tipo, nombre, apellido, documento, tipo_libreta) 
        VALUES ('$usuario', '$contrasena_encriptada', '$tipo', '$nombre', '$apellido', '$documento', '$tipo_libreta')";

if ($conn->query($sql) === TRUE) {
    echo "Los datos se ingresaron correctamente en la base de datos.";
} else {
    echo "Error al ingresar los datos: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
