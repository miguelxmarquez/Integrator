<?php
/*
*   # Integrator/main.php
*
*/
// Integrator Class
require_once "Integrator.php";

// New Resource Integrator
$resource = new Integrator();
$fecha = date('YmdHi');

/***  Menu de Bienvenida ***/ 
echo "Bienvenido a Integrator\n";
echo "Desesa realizar la importacion? Escriba 'SI' para continuar: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'SI'){
    echo "\n Saliendo!\n";
    exit;
}
fclose($handle);


echo "\n"; 
echo "Selecciones la tabla que desea importar\n";
echo "1. Clientes\n";
echo "2. Sedes\n";
echo "3. Cartera\n";
echo "4. Productos\n";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
$name = "\/".$fecha.'.csv';

switch ($line) {
    case 1:
        echo "La Tabla Clientes sera importada, no podra reversar esta accion. Escriba 'SI' para continuar: ";
        $line = fgets($handle);
        if(trim($line) == 'SI'){
            echo "Ejecutando tarea Clientes..!\n";

            // CSV Path/Name
            $file_dir = getcwd().'/public/tmp/';
            
            try {

                echo $file_name = getcwd().'/public/' . 'cliente.CSV';
                $folder = 'clientes';
                // Valida Ruta, Archivo y Lectura
                $resource->ValidatePath($file_name);

                // Ultimo CSV Generado hasta la Fecha
                echo $last = $resource->LastCSV($file_dir, $folder);
                echo "\n";
                echo $file_tmp = $file_dir.$folder."/".$last;
                echo "\n";
                $file_last = $resource->ReadCSV($file_tmp);

                // Copia de CSV Nuevo 
                echo $resource->CopyCSV($file_name, $folder, $fecha);

                // Ultimo CSV Generado (Copia Nuevo)
                echo $new = $resource->LastCSV($file_dir, $folder);
                echo "\n";
                echo $file_tmp = $file_dir.$folder."/".$new;
                echo "\n";
                $file_new = $resource->ReadCSV($file_tmp);
                
                print_r($arreglo = $resource->CompareCSV($file_last, $file_new));

                //$resource->CreateCSV($arreglo, $file_name, $name);
                
                // //Creando Archivo Base para Procesarlo
                // print_r($resource->CreateCSV($resource->ReadCSV($file_name), $file_name, $name));
                // //Execute Method for inDataLogic
                // $resource->ClientInData($resource->ReadCSV($client_file));
          
            } catch (Exception $e) {
          
                $type = 'inDataLogic-Client';
                $log = new Integrator();
                $log->CreateLog($type, $e);
          
            }

            exit;
        }

        break;
    case 2:
        echo "La Tabla Sedes sera importada, no podra reversar esta accion. Escriba 'SI' para continuar: ";
        $line = fgets($handle);
        break;
    case 3:
        echo "La Tabla Cartera sera importada, no podra reversar esta accion. Escriba 'SI' para continuar: ";
        $line = fgets($handle);
        break;
    case 4:
        echo "La Tabla Productos sera importada, no podra reversar esta accion. Escriba 'SI' para continuar: ";
        $line = fgets($handle);
        break;    
}

?>