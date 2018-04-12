<?php
/*
*   lalider/Integrator.php
*/
// Before: composer autoload
require_once 'vendor\autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

use Webmozart\Assert\Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

date_default_timezone_set('America/Bogota');
/*
*
*   # Integrator Class
*   # lalider/Integrator.php
*
*/
class Integrator {

//--------------------------------------------------------------------
// Return Array Cliente/InData
    public static function ClientInData($data){

            try {
                    array_shift($data);
                    $array_client = [];
                    foreach ($data as $key => $value) {
                          # Formato ClienteInData
                          $array_client = array(
                          'idCustomer' => trim(strval($data[$key][0])),
                          'identification' => trim(strval($data[$key][2])),
                          'businessName' => trim(strval($data[$key][1])),
                          'tradename' => trim(strval($data[$key][2])),
                          'credit' => floatval($data[$key][4]),
                          'isBlocked' => 0,
                          'state' => 1,
                          'availableCredit' => floatval($data[$key][5]),
                          'idPricelist' => intval($data[$key][9])
                          );
                    break;
                    }
                    //print_r($array_client);
                return $array_client;

            } catch (Exception $e) {

                $type = 'ClienteInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }


//--------------------------------------------------------------------
// Return Array Credit/InData
    public static function CreditInData($data){

            try {
                    array_shift($data);
                    $array_credit = [];
                    foreach ($data as $key => $value) {
                          # Formato CreditInData
                          $array_credit = array(
                            'idCustomer'      => trim(strval($data[$key][0])),
                            'credit'          => floatval($data[$key][4]),
                            'availableCredit' => floatval($data[$key][5])
                          );
                    break;
                    }
                    //print_r($array_credit);

                return $array_credit;

            } catch (Exception $e) {

                $type = 'WalletInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }


//--------------------------------------------------------------------
// Return Array Sede/InData
    public static function SeatInData($data){

            try {
                    array_shift($data);
                    $array_seat = [];
                    foreach ($data as $key => $value) {
                          # Formato SeatInData
                          $array_seat = array(
                          'idCustomer' => trim(strval($data[$key][0])),
                          'identification' => trim(strval($data[$key][2])),
                          'idCustomerOffice' => trim(strval($data[$key][2]."-0")),
                          'address' => trim(strval($data[$key][6])),
                          'name' => 'Principal',
                          'countryId' => 'null',
                          'countryName' => 'Colombia',
                          'cityId' => 'null',
                          'cityName' => 'Cali',
                          'contactPerson1' => trim(strval($data[$key][3])),
                          'cellphoneContact' => 'null',
                          'phoneNumber' => trim(strval($data[$key][7])),
                          );
                    break;
                    }
                    //print_r($array_seat);
                return $array_seat;

            } catch (Exception $e) {

                $type = 'SeatInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }



//--------------------------------------------------------------------
// Return Array Cartera/InData
    public static function WalletInData($data){

            try {
                    array_shift($data);
                    $array_wallet = [];
                    foreach ($data as $key => $value) {
                          # Formato ClienteInData
                          $array_wallet = array(
                            'idCustomer' => trim(strval($data[$key][3])),
                            'invoiceNumber' => trim(strval($data[$key][1]."-".$data[$key][2])),
                            'totalValue' => round(($data[$key][4]), 2),
                            'balance' => round(floatval($data[$key][5]), 2),
                            'taxValue' => round(floatval(0), 2),
                            'createDate' => Integrator::FunctionDate($data[$key][6]),
                            'dueDate' => Integrator::FunctionDate($data[$key][7])
                          );
                    break;
                    }

                    //print_r($array_wallet);

                return $array_wallet;

            } catch (Exception $e) {

                $type = 'WalletInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }

//--------------------------------------------------------------------
      // Return Array Kardex/InData
    public static function KardexInData($data){

            try {
                    array_shift($data);
                    $array_kardex = [];
                    foreach ($data as $key => $value) {
                          # Formato KardexInData
                          $array_kardex = array(
                          'idProduct' => trim(strval($data[$key][0])),
                          'code' => trim(strval($data[$key][1])),
                          'productRef' => trim(strval($data[$key][3])),
                          'name' => trim(strval($data[$key][2])),
                          'unit' => trim(strval($data[$key][5])),
                          'currencySymbol' => '$',
                          'description' => trim(strval($data[$key][2])),
                          'idBrand' => 'null',
                          'brand' => trim(strval($data[$key][3])),
                          'idCategory' => 'null',
                          'categoryName' => trim(strval($data[$key][13])),
                          'idSubcategory' => 'null',
                          'subcategoryName' => trim(strval($data[$key][14])),
                          'idLine' => 'null',
                          'lineName' => 'null',
                          'supplierName' => 'null',
                          'price' => 'null',
                          'tax' => floatval($data[$key][17]),
                          'discountPrice' => '0',
                          'state' => 0
                          );
                    break;
                    }
                    //print_r($array_kardex);
                return $array_kardex;

            } catch (Exception $e) {

                $type = 'KardexInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }

//--------------------------------------------------------------------
    // Crea Log
    public function CreateLog($type, $e){

        $log = new Logger($type);
        $formatter = new LineFormatter(null, null, false, true);
        $debugHandler = new StreamHandler('log\debug.log', Logger::DEBUG);
        $debugHandler->setFormatter($formatter);
        $log->pushHandler($debugHandler);
        $log->debug($e);

    }

//--------------------------------------------------------------------
    // Lee Archivo CSV
    public static function ReadCSV($file){

      $data = [];

          if (($archive = fopen($file, "r")) !== FALSE) {
              // Situamos el puntero al principio del archivo
              fseek($archive, 0);
              while (($line = fgetcsv($archive, 0, ',', '"', "//")) !== FALSE) {
                // Array to UTF8
                array_map('utf8_encode',$line);
                array_push($data, $line);
              }
            fclose($archive);
          }
      // Retorna Arreglo Multidimensional
      return $data;
    }

//--------------------------------------------------------------------
    // Valida Variable, Ruta, Archivo y Lectura
    public static function ValidatePath($file){
            try {
                Assert::fileExists($file, 'El directorio no existe. Tiene: %s');
                Assert::file($file, 'El archivo no existe. Tiene: %s');
                Assert::readable($file, 'El directorio no puede leerse. Tiene: %s');
            } catch (Exception $e) {
                $type = 'ValidatePath';
                $log = new Integrator();
                $log->CreateLog($type, $e);
            }
    }

//--------------------------------------------------------------------
    // Valida String
    public static function ValidateString($value){

            try {
                Assert::string($value, 'El campo no es String. Tiene: %s');
            } catch (Exception $e) {
                $type = 'ValidateString';
                $log = new Integrator();
                $log->CreateLog($type, $e);
            }
    }

//--------------------------------------------------------------------
    // Valida Integer and Natural
    public static function ValidateInteger($value){
            try {
                Assert::integer($value, 'El campo no es Integer. Tiene: %s');
                Assert::natural($value, 'El campo no es Natural. Tiene: %s');
            } catch (Exception $e) {
                $type = 'ValidateInteger';
                $log = new Integrator();
                $log->CreateLog($type, $e);
            }
    }

//--------------------------------------------------------------------
    // Valida Float
    public static function ValidateFloat($value){
            try {
                Assert::float($value, 'El campo no es Float. Tiene: %s');
            } catch (Exception $e) {
                $type = 'ValidateFloat';
                $log = new Integrator();
                $log->CreateLog($type, $e);
            }
    }

//--------------------------------------------------------------------
    // Format DateInData
    public static function FunctionDate($value)
    {
          $date = str_replace('/', '-', $value);
          $time = strtotime($date);
          // date('Y-m-d',time())
          $fecha = ($time === false) ? '0000-00-00' : date('Y-m-d', $time);
          return $fecha;

    }



}
