<?php
    if(isset($_POST["submit"])){
        $archivo = $_FILES['archivo'];

        $nombreArchivo = $_FILES['archivo']['name'];
        $directorioActual = $_FILES['archivo']['tmp_name'];

        $separarNombre = explode('.', $nombreArchivo);
        $extension = strtolower(end($separarNombre));
        if ($extension == 'csv') {
            $directorio = 'archivos/'.$nombreArchivo;
            move_uploaded_file($directorioActual, $directorio);
            $archivoValido = true;
        } else {
            echo "Archivo Invalido";
            $archivoValido = false;
        }
    }
    
    function leerCSV($nombre, $header=false) {
        $archivoAbierto = fopen('archivos/'.$nombre, "r");
        echo '<table class="table">';
        echo '<thead>';
        if ($header) {
            $headerValidacion = ['id','nombre','total_departamentos'];
            $contenido = fgetcsv($archivoAbierto);
            if (Count($contenido) == 3) {
                echo '<tr>';
                    foreach ($contenido as $columnaHeader) {
                        if (condition) {
                            # code...
                        }
                        echo "<th>$columnaHeader</th>";
                    }
                echo '</tr>';
            }
        }
        echo '</thead>';
            echo '<tbody>';
            while ($contenido = fgetcsv($archivoAbierto)) {
                echo '<tr>';
                foreach ($contenido as $columna) {
                    echo "<td>$columna</td>";
                }
                echo '</tr>';
            }
            echo '</tbody>';
        echo '</table>';
        fclose($archivoAbierto);
    }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="table-responsive">
            <?php
                if ($archivoValido) {
                    leerCSV($nombreArchivo, true);
                }
            ?>
        </div>
    </div>
</body>
</html>