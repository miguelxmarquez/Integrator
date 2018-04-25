<?php
/*
*   # Integrator/main.php
*
*/
// Integrator Class
require_once "Integrator.php";

// New Resource Integrator
$resource = new Integrator();
$fecha = date('YmdH');

/***  Menu de Bienvenida ***/ 
echo "Bienvenido a Integrator\n";
echo "Desesa realizar la importacion? Escriba 'SI' para continuar: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
if(trim($line) != 'SI'){
    echo "Saliendo!\n";
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

switch ($line) {
    case 1:
        echo "La Tabla Clientes sera importada, no podra reversar esta accion. Escriba 'SI' para continuar: ";
        $line = fgets($handle);
        if(trim($line) == 'SI'){
            echo "Ejecutando tarea Clientes..!\n";
            
            try {

                // CSV Path/Name
                $client_file = getcwd().'/public/' . 'cliente.CSV';
                // Valida Ruta, Archivo y Lectura
                $resource->ValidatePath($client_file);
                // Execute Method for inDataLogic
                $resource->ClientInData($resource->ReadCSV($client_file));
          
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