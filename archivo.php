<?php require("clases.php");?>
<?php
    $cadeConexion = baseDatos::conectarDB("csv");
    foreach($Continentes as $continente){
        baseDatos::GuardarBD2($continente-> ID,$continente-> Nombre,$cadeConexion);
    }
    session_start();

    if(!isset($_SESSION["archivoCSV"])){
        $_SESSION["archivoCSV"] = [];
    }

    if(isset($_SESSION["archivoCSV"])){
        $archivoCSV = $_SESSION["archivoCSV"];
    }

    if(!isset($_SESSION["nombreArchivo"])){
        $_SESSION["nombreArchivo"] = "";
    }
    $nombreArchivo =  $_SESSION["nombreArchivo"];
    
    if(isset($_POST["submit"])){
        if($_FILES['archivo']['name'] != ""){
            $archivo = $_FILES['archivo'];
    
            $nombreArchivo = $_FILES['archivo']['name'];
            $directorioActual = $_FILES['archivo']['tmp_name'];
            $_SESSION["nombreArchivo"] = $nombreArchivo;
            $nombreArchivo =  $_SESSION["nombreArchivo"];
            $separarNombre = explode('.', $nombreArchivo);
    
            $extension = strtolower(end($separarNombre));
            if ($extension == 'csv') {
                $directorio = 'archivos/'.$nombreArchivo;
                move_uploaded_file($directorioActual, $directorio);
                $archivoValido = true;
                $archivoAbierto = fopen('archivos/'.$nombreArchivo, "r");
                while ($contenido = fgetcsv($archivoAbierto)) {            
                    if($contenido[0] != "id"){
                        if (is_numeric($contenido[0]) && is_numeric($contenido[2]) && $contenido[2] < 6 && $contenido[2] > 0) {
                            $nuevoPais = new Pais($contenido[0],$contenido[1],$contenido[2], true);
                        } else {
                            $nuevoPais = new Pais($contenido[0],$contenido[1],$contenido[2], false);   
                        }
                        Pais::agregaPais($archivoCSV,$nuevoPais);  
                    }            
                    $_SESSION["archivoCSV"] = $archivoCSV;
                    $archivoCSV = $_SESSION["archivoCSV"];         
                }
                fclose($archivoAbierto);
                unlink('archivos/'.$nombreArchivo);
            } else {
                echo "Archivo Invalido";
                $archivoValido = false;
            }
        }
        else{
            echo'No ha subido ningun archivo!';
        }
    }

    if(isset($_POST["archivoNuevo"])){
        session_destroy();
        header("location: index.php");
    }
    
    if(isset($_POST["SubirBasedatos"])){
        $indice = 0;
        $datosRepetidosBD = false;
        if($archivoCSV != null){
            foreach($archivoCSV as $pais){
                if ($pais->FilaCorrecta == true) {
                    $verifica = baseDatos::GuardarBD($pais-> ID, $pais-> Nombre,$pais->Continente,$cadeConexion);
                    if($verifica){
                        Pais::borraPais($archivoCSV,$indice);
                        $_SESSION["archivoCSV"] = $archivoCSV;
                        $archivoCSV = $_SESSION["archivoCSV"];
                    }else{

                        $datosRepetidosBD = true;
                        
                    }
                } else {
                    $indice++;
                }    
            }

            if ($indice > 0) {
                echo'Hay datos incorectos!';echo'<br>';
            }

            if ($datosRepetidosBD == true){
                echo'Hay datos repetidos <br>';
            }                  
        }
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
        <form method="POST">
            <button class="btn btn-dark" name = "archivoNuevo">Subir Otro Archivo</button>
            <button class="btn btn-dark" name = "SubirBasedatos">Subir a BD</button>

        </form>
        <div class="table-responsive">
            <table class="table table-light table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Continente</th>
                </tr>
                <?php
                    if($archivoCSV != null){
                        foreach($archivoCSV as $dato){
                            $nombreContinente = Continente::nombreContinente($dato-> Continente,$Continentes);

                ?>
                            <tr <?php if($dato-> FilaCorrecta == false){echo'class="bg-danger"';} ?>>
                                <td><?php echo $dato-> ID; ?></td>
                                <td><?php echo $dato-> Nombre; ?></td>
                                <td><?php echo $nombreContinente; ?></td>
                            </tr>
                <?php
                        }
                    }
                    //session_destroy();
                ?>
            </table>
        </div>
    </div>
</body>
</html>