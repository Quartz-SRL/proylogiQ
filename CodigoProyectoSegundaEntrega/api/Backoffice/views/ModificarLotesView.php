<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/styles-modificar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Modificar paquete</title>
</head>
<body>
<div id="modificarDiv">
    <h2>Modificar Paquete</h2>
   

        <?php
        include (__DIR__ . '/../controllers/LotesController.php');
        $controlador=new loteController();
        if(isset($_GET['idLote_modificar'])){
            $codigo = $_GET['idLote_modificar'];
            $lote= $controlador->obtenerLotesPorId($codigo);
            
        } ?>


            <form id="modificarLotesForm" action='http://localhost/codigoProyecto/api/Backoffice/views/LotesView.php'>
                <label for="codigo">idLote</label>
                <input class="inputs" type=text name="idLote" value=<?php echo $lote['idLote']; ?>>
                <label for="peso">Peso Lote</label>
                <input class="inputs" type=text name="pesoLote" value="<?php echo $lote['pesoLote']; ?>">
                <label for="categoria">Destino</label>
                <input class="inputs" type=text name="destino" value="<?php echo $lote['destino']; ?>">
                <label for="calle">Fecha Ingreso</label>
                <input class="inputs" type=text name="fechaIngresoLote" value="<?php echo $lote['fechaIngresoLote']; ?>"> 
                
                <input type="hidden" name="modificarLotesForm" value="modificarLotesForm" >
                <input type="submit" value="modificarLote" id="btnAlta" onclick="modPaquete()">
            </form>
            <a href="LotesView.php"><button class="button">Cancelar</button></a>
        
    </div>

    <script>
        function modPaquete(){
            var formData = $('#modificarLotesForm').serialize();
            $.ajax({
                url: 'http://localhost/codigoProyecto/api/backoffice/controllers/LotesController.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                   if(response.success){
                    alert("lote modificado correctamente");
                    
                   }else{
                    alert("error al modificar el paquete");
                   }
                },
                error: function(){
                    alert("Error al comunicarse con el servidor")
                }
            });
        }
        

    </script>
</body>
</html>