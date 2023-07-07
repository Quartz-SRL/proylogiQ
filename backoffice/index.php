<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Ingreso</title>
  <script>
    function habilitarCampos() {
      var tipo = document.getElementById('tipo').value;
      var camposCamionero = document.getElementsByClassName('camionero');

      if (tipo === 'camionero') {
        for (var i = 0; i < camposCamionero.length; i++) {
          camposCamionero[i].disabled = false;
        }
      } else {
        for (var i = 0; i < camposCamionero.length; i++) {
          camposCamionero[i].disabled = true;
        }
      }
    }
  </script>
</head>
<body>
  <h2>Formulario de Ingreso</h2>
  <form action="ingreso.php" method="post">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required><br><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required><br><br>

    <label for="tipo">Tipo:</label>
    <select id="tipo" name="tipo" onchange="habilitarCampos()" required>
      <option value="camionero">Camionero</option>
      <option value="empleado_almacen">Empleado de Almacén</option>
    </select><br><br>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required><br><br>

    <label for="documento">Documento:</label>
    <input type="text" id="documento" name="documento" required><br><br>

    <label for="tipo_libreta">Tipo de Libreta:</label>
    <select id="tipo_libreta" name="tipo_libreta" required>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>

      <p>pruba</p>
    </select><br><br>

    <input type="submit" value="Ingresar">
  </form>
</body>
</html>