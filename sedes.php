<?php
/*
*   # lalider/sedes.php
*
*/
// Integrator Class
require_once 'Integrator.php';
// Composer Autoload
require_once 'vendor\autoload.php';
// API inDataLogic
require_once '..\api_tcintegrator\indata_ws\inDataLogic.php';

  try {

    // CSV Path/Name
    $client_file = getcwd().'/public/' . 'cliente.CSV';
    // New Resource Integrator
    $resource = new Integrator();
    $tc = new inDataLogic();
    // Valida Ruta, Archivo y Lectura
    $resource->ValidatePath($client_file);
    // Execute Method for inDataLogic
    print_r($resource->SeatInData($resource->ReadCSV($client_file)));

  } catch (Exception $e) {

    $type = 'inDataLogic-Seat';
    $log = new Integrator();
    $log->CreateLog($type, $e);

  }

?>
