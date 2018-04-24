<?php
require_once "Integrator.php";

// New Resource Integrator
$resource = new Integrator();
$fecha = date('YmdH');
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
        if(trim($line) != 'SI'){
            echo "Buscando Archivos..!\n";
            sleep(3000);
            // CSV Path/Name
            $kardex_file = getcwd().'/public/' . 'kardex.CSV';
            $kardex_new = getcwd().'/public/Procesando/' . $fecha .'kardex.CSV';
            mkdir(dirname($kardex_new), 0777, true);
            if (!copy($kardex_file, $kardex_new)) {
            echo "Error al copiar $fichero...\n";
            }
            require_once 'productos.php';
            // Valida Ruta, Archivo y Lectura
            $resource->ValidatePath($kardex_file);
            // Execute Method for inDataLogic
            // $resource->KardexInData($resource->ReadCSV($kardex_file));


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