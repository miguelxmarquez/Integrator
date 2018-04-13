<?php
/*
*   # Integrator/sedes.php
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
      $wallet_file = getcwd().'/public/' . 'cartera.CSV';
      // New Resource Integrator
      $resource = new Integrator();
      // Valida Ruta, Archivo y Lectura
      $resource->ValidatePath($wallet_file);
      // Execute Method for inDataLogic
      $resource->WalletInData($resource->ReadCSV($wallet_file));

  } catch (Exception $e) {

      $type = 'inDataLogic-Wallet';
      $log = new Integrator();
      $log->CreateLog($type, $e);

  }

?>
