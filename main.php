<?php
require_once "Integrator.php";

$gestor = new Integrator();


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