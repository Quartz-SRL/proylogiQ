<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Agregar trayecto</title>
</head>
<body>
    <h2>Agregar nuevo trayecto</h2>
    <form action="" method="POST">
    
    <p>Selecciona los almacenes:</p>
        <?php
        include(__DIR__ . '/../controllers/AlmacenController.php');
        $controlador = new almacenController();
        $almacenesJSON = $controlador->obtenerAlmacen();
        $almacenes = json_decode($almacenesJSON, true);
        
        foreach ($almacenes as $almacen) {
            
            echo '<input type="checkbox" name="almacenes_seleccionados[]" value="' . $almacen['idAlmacen'] . '"> ' . $almacen['ciudad'] ;
            echo' <label for="tiempoAlmCentral">Tiempo en almacén central:</label>
            <input type="time" name="tiempoAlmCentral[]" required><br>';
        }
        ?>
        <br>
        <input type="submit" value="Agregar Trayecto">
    </form>

    <script>
        $(document).ready(function () {
            // Manejar clic en el botón de agregar trayecto
            $("#btnAgregarTrayecto").click(function () {
                // Enviar el formulario con AJAX
                $.ajax({
                    url: "procesar_agregar_trayecto.php",
                    type: "post",
                    data: $("#formTrayecto").serialize(), // Serializar el formulario
                    success: function (response) {
                        // Manejar la respuesta del servidor
                        console.log(response);
                        // Puedes agregar más lógica aquí según la respuesta del servidor
                    },
                    error: function (error) {
                        // Manejar errores
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>