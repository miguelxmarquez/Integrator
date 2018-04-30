<?php
/*
*   # Integrator/main.php
*
*/
// Integrator Class
// Integrator Class
require_once 'Integrator.php';
// Composer Autoload
require_once 'vendor\autoload.php';
// API inDataLogic
require_once 'api_tcintegrator\indata_ws\inDataLogic.php';

// New Resource Integrator
$indata = new Integrator();

/***  Menu de Bienvenida ***/ 
echo "Bienvenido a Integrator\n";
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
                
                $indata->MigraCSV();                
          
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