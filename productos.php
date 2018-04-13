<?php
/*
*   # Integrator/productos.php
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
      $kardex_file = getcwd().'/public/' . 'kardex.CSV';
      // New Resource Integrator
      $resource = new Integrator();
      // Valida Ruta, Archivo y Lectura
      $resource->ValidatePath($kardex_file);
      // Execute Method for inDataLogic
      print_r($resource->KardexInData($resource->ReadCSV($kardex_file)));

  } catch (Exception $e) {

      $type = 'inDataLogic-Client';
      $log = new Integrator();
      $log->CreateLog($type, $e);

  }

?>
