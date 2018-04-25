<?php
/*
*   # lalider/clientes.php
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
      // Valida Ruta, Archivo y Lectura
      $resource->ValidatePath($client_file);
      // Execute Method for inDataLogic
      $resource->ClientInData($resource->ReadCSV($client_file));

  } catch (Exception $e) {

      $type = 'inDataLogic-Client';
      $log = new Integrator();
      $log->CreateLog($type, $e);

  }

?>
