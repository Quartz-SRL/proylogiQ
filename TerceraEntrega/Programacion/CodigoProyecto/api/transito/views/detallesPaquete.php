<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Paquete</title>
    <link rel="stylesheet" type="text/css" href="../../../css/styles-detallesPaquete.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="../../../index.php"><img src="../../../img/logo.png" alt="Logo"></a>
        </div>
        <nav class="primer-menu">
            <ul>
                <li><a href="#">Idioma</a></li>
                <li><a href="../../../paginas/chofer.php">Volver al menú</a></li>
            </ul>
        </nav>
    </header>
    <div class="header-line"></div>

    <?php
    include (__DIR__ . '/../controllers/transitoController.php');
    $controlador = new TransitoController();

    if (isset($_GET['codigo_paquete'])) {
        $codigo = $_GET['codigo_paquete'];
        $paqueteJSON = $controlador->buscarPaquete($codigo);
        $paqueteDetalle = json_decode($paqueteJSON, true);

        if ($paqueteDetalle) {
            ?>
            <div class="paquete-details-container">
                <h1>Detalles del Paquete</h1>
                <ul>
                    <li><strong>Código del Paquete:</strong> <?php echo $paqueteDetalle[0]['codigoPaquete']; ?></li>
                    <li><strong>Descripción:</strong> <?php echo $paqueteDetalle[0]['direccion']; ?></li>
                    <li><strong>Destinatario:</strong> <?php echo $paqueteDetalle[0]['departamento']; ?></li>
                    <li><strong>Dirección:</strong> <?php echo $paqueteDetalle[0]['pesoPaquete']; ?></li>
                </ul>
                <div class="button-container">
                    <a href="javascript:history.back()" class="back-button">Volver</a>
                </div>
            </div>
            <?php
        } else {
            echo '<p class="error-message">No se encontraron detalles para el paquete con el código ' . $codigo . '</p>';
        }
    } else {
        echo '<p class="error-message">No se proporcionó un código de paquete válido.</p>';
    }
    ?>
</body>
</html>
