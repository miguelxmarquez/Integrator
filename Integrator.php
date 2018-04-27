<?php
/*
*   Integrator/Integrator.php
*/
// Before: composer autoload
require_once 'vendor\autoload.php';
require_once 'api_tcintegrator\indata_ws\inDataLogic.php';

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
    public static function ClientInData($data){

      $tc = new inDataLogic();
      $idx = 0;

            try {

                    array_shift($data);
                    $array_client = [];

                    foreach ($data as $key => $value) {
                            # Formato ClienteInData
                            $array_client = array(
                            'idCustomer' => trim(strval($data[$key][0])),
                            'identification' => trim(strval($data[$key][2])),
                            'businessName' => Integrator::CleanBussinessName(Integrator::CleanString($data[$key][1])),
                            'tradename' => Integrator::CleanName(Integrator::CleanString($data[$key][1])),
                            'credit' => floatval($data[$key][4]),
                            'isBlocked' => 0,
                            'state' => 1,
                            'availableCredit' => floatval($data[$key][5]),
                            'idPricelist' => intval($data[$key][9]),
							'email' => Integrator::CleanString($data[$key][11]),
                            );
                            // Indice alterno
                            $idx++;
                            // Insert On DataBase with API and Logging
                            try {
                              $cath = $tc->createCustomerTakeOrder($array_client);
                              Integrator::LogMigration('ClientImport', $idx, $array_client['idCustomer'], 'Sending', 'ClientInData', $array_client, $cath);
                              echo 'Linea: #' . $idx . ', Campo Clave (ClientInData): ' . $array_client['idCustomer'] . ', Retorno: ' .$cath . "\n";

                            } catch (Exception $e) {
                              Integrator::LogMigration('Exception Catched: ', $idx, $array_client['idCustomer'], $e, 'ClientInData', $array_client);
                            }
                            //break;
                    }
					
                return $cath;

            } catch (Exception $e) {

                $type = 'ClienteInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }


//--------------------------------------------------------------------
    public static function CreditInData($data){

      $tc = new inDataLogic();
      $idx = 0;

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
                            $idx++;
                            // Insert On DataBase with API and Logging
                            try {
                              $cath = $tc->setStatusCredit($array_credit);;
                              Integrator::LogMigration('CreditImport', $idx, $array_credit['idCustomer'], 'Sending', 'CreditInData', $array_credit, $cath);
                              echo 'Linea: #' . $idx . ', Campo Clave (CreditInData): ' . $array_credit['idCustomer'] . ', Retorno: ' .$cath . "\n";

                            } catch (Exception $e) {
                              Integrator::LogMigration('Exception Catched: ', $idx, $array_credit['idCustomer'], $e, 'CreditInData', $array_credit);
                            }
                            //break;
                    }
                return $cath;

            } catch (Exception $e) {

                $type = 'CreditInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }


//--------------------------------------------------------------------
    public static function SeatInData($data){

      $tc = new inDataLogic();
      $idx = 0;

            try {
                    array_shift($data);
                    $array_seat = [];

                    foreach ($data as $key => $value) {
                            # Formato SeatInData
                            $array_seat = array(
                            'idCustomer' => trim(strval($data[$key][0])),
                            'identification' => trim(strval($data[$key][2])),
                            'idCustomerOffice' => Integrator::CleanString($data[$key][2]/*.'-0'*/),
                            'address' => trim(strval($data[$key][6])),
                            'name' => 'Principal',
                            'countryId' => '',
                            'countryName' => '',
                            'cityId' => trim(strval($data[$key][8])),
                            'cityName' => '',
                            'contactPerson1' => trim(strval($data[$key][3])),
                            'cellphoneContact' => '',
                            'phoneNumber' => trim(strval($data[$key][7])),
                            );
                            $idx++;
                            // Insert On DataBase with API and Logging
                            try {
                              $cath = $tc->createCustomerOfficeTakeOrder($array_seat);;
                              Integrator::LogMigration('SeatImport', $idx, $array_seat['idCustomer'], 'Sending', 'SeatInData', $array_seat, $cath);
                              echo 'Linea: #' . $idx . ', Campo Clave (SeatInData): ' . $array_seat['idCustomer'] . ', Retorno: ' .$cath . "\n";

                            } catch (Exception $e) {
                              Integrator::LogMigration('Exception Catched: ', $idx, $array_seat['idCustomer'], $e, 'SeatInData', $array_seat);
                            }
                            // break;
                    }
                return $cath;

            } catch (Exception $e) {

                $type = 'SeatInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }



//--------------------------------------------------------------------
    public static function WalletInData($data){

      $tc = new inDataLogic();
      $idx = 0;

            try {
                    array_shift($data);
                    $array_wallet = [];
                    foreach ($data as $key => $value) {
                            # Formato WalletInData
                            $array_wallet = array(
                              'idCustomer' => trim(strval($data[$key][3])),
                              'invoiceNumber' => trim(strval($data[$key][1]."-".$data[$key][2])),
                              'totalValue' => round(($data[$key][4]), 2),
                              'balance' => round(floatval($data[$key][5]), 2),
                              'taxValue' => round(floatval(0), 2),
                              'createDate' => Integrator::FunctionDate($data[$key][6]),
                              'dueDate' => Integrator::FunctionDate($data[$key][7])
                            );
                        // Indice alterno
                        $idx++;
                        // Insert On DataBase with API and Logging
                        try {
                          $cath = $tc->createCustomerCartera($array_wallet);
                          Integrator::LogMigration('WalletImport', $idx, $array_wallet['idCustomer'], 'Sending', 'WalletInData', $array_wallet, $cath);
                          echo 'Linea: #' . $idx . ', Campo Clave (WalletInData): ' . $array_wallet['idCustomer'] . ', Retorno: ' .$cath . "\n";

                        } catch (Exception $e) {
                          Integrator::LogMigration('Exception Catched: ', $idx, $array_wallet['idCustomer'], $e, 'WalletInData', $array_wallet);
                        }
                    }

                return $cath;

            } catch (Exception $e) {

                $type = 'WalletInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }

//--------------------------------------------------------------------
    public static function KardexInData($data){

      $tc = new inDataLogic();
      $idx = 0;

            try {
                    array_shift($data);
                    $array_kardex = [];
                    foreach ($data as $key => $value) {
                            # Formato KardexInData
                            $array_kardex = array(
                            'idProduct' => trim(strval($data[$key][0])),
                            'code' => trim(strval($data[$key][0])),
                            'productRef' => trim(strval($data[$key][19])),
                            'name' => Integrator::CleanString(Integrator::Signal(($b = $data[$key][2]))),
                            'unit' => trim(strval($data[$key][5])),
                            'currencySymbol' => '$',
                            'description' => Integrator::CleanString(Integrator::Signal(($data[$key][2]))),
                            'idBrand' => '',
                            'brand' => Integrator::CleanString($data[$key][3]),
                            'idCategory' => '',
                            'categoryName' => trim(strval($data[$key][13])),
                            'idSubcategory' => '',
                            'subcategoryName' => trim(strval($data[$key][14])),
                            'idLine' => trim(strval($data[$key][20])),
                            'lineName' => '',
                            'supplierName' => '',
                            'price' => 0,
                            'tax' => floatval($data[$key][17]),
                            'discountPrice' => '0',
                            'state' => 1
                            );
                            // Indice alterno
                            $idx++;
                            // Insert On DataBase with API and Logging
                            
							try {

                              $cath = $tc->createProduct($array_kardex);
                              Integrator::LogMigration('KardexImport', $idx, $array_kardex['idProduct'], 'Sending', 'KardexInData', $array_kardex, $cath);
                              echo 'Linea: #' . $idx . ', Campos Clave (KardexInData): ' . $array_kardex['idProduct'] . ', Retorno: ' .$cath . "\n";

							} catch (Exception $e) {
                              Integrator::LogMigration('Exception Catched: ', $idx, $array_kardex['idProduct'], $e, 'KardexInData', $array_kardex);
                            }
                            break;
                    }
                return $cath;

            } catch (Exception $e) {

                $type = 'KardexInData';
                $log = new Integrator();
                $log->CreateLog($type, $e);

            }
    }

/*********************************************************        UTILITARIOS        ******************************************************************************/
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    // Lee Archivo CSV
    public static function ReadCSV($file){

        $data = [];
  
            if (($archive = fopen($file, "r")) !== FALSE) {
                // Situamos el puntero al principio del archivo
                fseek($archive, 0);
                while (($line = fgetcsv($archive, 0, ',')) !== FALSE) {
                  array_map('utf8_encode', $line);
                  array_push($data, $line);
                }
              fclose($archive);
            }
        // Retorna Arreglo Multidimensional
        return $data;
    }
  
//--------------------------------------------------------------------
    // Compara Archivos CSV y Retorna la Diferencia
    public static function CompareCSV($file_new, $file_last){
        $data = [];
        // Comparacion de Archivo Nuevo con Respecto al Ultimo Generado
        $data = array_diff_assoc($file_new, $file_last);

        return $data;
    }
  
//--------------------------------------------------------------------
    // Copia Archivo CSV
    public static function CopyCSV($file_name, $folder, $fecha){

        if (copy($file_name, 'public/tmp/'. $folder .'/'.$fecha.'.CSV')) {
            $log = "Se ha copiado el archivo corretamente!\n";
        } else {
            $log = "Se produjo un error al copiar el fichero!\n";
        }

      return $log;
    }
 
//--------------------------------------------------------------------
    // Lee Directorio, Ordena Archivos y Retorna Ultimo 
    public static function LastCSV($file_name, $folder){
        
        try{ 
                $ficheros  = scandir($file_name.$folder, 1);
                $log = $ficheros[0];
            } catch(Exception $e){
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}

      return $log;
    }

//--------------------------------------------------------------------
    // Crea Archivo CSV
    public static function CreateCSV($datos, $folder, $name){

        try{
			// Nombre Archivo CSV y Parametros para fputcsv

			$csvPath = 'C:\xampp4\htdocs\php\Integrator\public\tmp/'.$folder.'/'.$name;
			$csvh = fopen($csvPath, 'a+');
			$d = ',';
			$e = '"';

			// Creacion CSV (Si existe se actualiza, sino se crea uno nuevo cuando el minuto sea diferente)
			foreach($datos as $record) {
				//$data = $record->toArray(false); // false for the shallow conversion
				if(fputcsv($csvh, $record, $d, $e)){
					echo 'Archivo CSV Escrito! '.print_r($record).' \n';
				}else{
					echo 'Error en Escritura de Archivo CSV !';
				}
			}

			fclose($csvh);

		} catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
	// Asignamos Valores a Nuestras Variables
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
    public static function FunctionDate($value){

          $date = str_replace('/', '-', $value);
          $time = strtotime($date);
          // date('Y-m-d',time())
          $fecha = ($time === false) ? '0000-00-00' : date('Y-m-d', $time);
          return $fecha;

    }

//--------------------------------------------------------------------
    // Format DateInData
    public static function CleanString($value){

          $search = ['¥', '½', '¾', 'ö', '¢', 'ç', 'ä', 'å', '÷', 'ó', '«', '®', '©', '¸', '?'];
          $string = trim(strval(str_replace($search, 'Ñ', utf8_encode($value))));
          return $string;

    }
//--------------------------------------------------------------------
    // Format BussinessName
    public static function CleanBussinessName($value){

        $cadena = explode('(',$value);
		$tmp = explode(')', $cadena[1]);
		$bn = trim(implode($tmp));
		if($bn == ""){
			$bn = $value;
		}
        return $bn;

    }
//--------------------------------------------------------------------
    // Format Name
    public static function CleanName($value){

        $cadena = explode('(',$value);
		$bn = trim($cadena[0]);
		if($bn == ""){
			$bn = $value;
		}
        return $bn;

    }
//--------------------------------------------------------------------
    public static function Signal($string){

        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'ç', 'Ç'),
            array('n', 'c', 'C',),
            $string
        );

        $string = str_replace( array("\\", "º", "~",
        "@", "|", "!", "·", "$", "&", "(", ")", "?",
        "¡", "¿", "[", "^", "<code>", "]", "+", "}",
        "{", ">", "< ", ";", ",", ":", "" ," "), ' ', $string );

        utf8_encode($string);

      return $string;
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
    // Crea Log de Migracion
    public static function LogMigration($type, $idx, $key, $event, $from, $row, $cath){

        $log = new Logger($type);
        $fecha = date('YmdH');
        $f_dir = date('Ymd');
        $dir = 'C:\INDATA\Migracion\Integrator-testing\log\migracion-'.$f_dir.'\import-'. $from .'-';
        $ext = '.log';
        $rec = implode(',' , $row);
        $formatter = new LineFormatter(null, null, false, true);
        $noticeHandler = new StreamHandler($dir.$fecha.$ext, Logger::NOTICE);
        $noticeHandler->setFormatter($formatter);
        $log->pushHandler($noticeHandler);
        $log->notice($event. ' in: Linea: #' . $idx . ', Campo Clave: ' . $key . ', Registro::[' . $rec . ']' . ', Respuesta Servidor: ' .$cath);

    }

}
