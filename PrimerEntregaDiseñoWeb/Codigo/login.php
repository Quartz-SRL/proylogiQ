<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipoUsuario"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

   

    if ($tipoUsuario == "chofer") {
        header("Location: chofer/chofer.html"); // Redirigir a la página del chofer
        exit();
    } elseif ($tipoUsuario == "almacen") {
        header("Location: almacen/almacen.html"); // Redirigir a la página del administrador
        exit();
    }elseif($tipoUsuario == "administrador") {
        header("Location: backoffice/backoffice.html"); // Redirigir a la página del administrador
        exit();

    }
}
?>