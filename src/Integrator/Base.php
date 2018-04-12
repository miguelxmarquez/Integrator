<?php



$info = array(                
	'idCustomer' => $d['id'],                
	'identification' => $d['nit'],                
	'businessName' => trim($d['razon_comercial']),                
	'tradename' => trim($d['nombres']),                
	'credit' => round($d['cupo_credito'],2),                
	'isBlocked' => $bloqueo,                
	'state' =>$state,                
	'avalilableCredit' => 'null',                
	'idPricelist' => $lista        
);

$info = array('idCustomer' => $dat['id'],            
	'identification' => $dat['nit'],            
	'idCustomerOffice' => $dat['nit']."-0",            
	'address' => $dat['direccion'],            
	'name' => 'Principal',            
	'countryId' => $dat['y_pais'],            
	'countryName' => $dat['pais'],            
	'cityId' => $dat['y_ciudad'],            
	'cityName' => $dat['ciudad'],           
	'contactPerson1' => $dat['contacto'],            
	'cellphoneContact' => $dat['celular'],            
	'phoneNumber' => $dat['telefono_1'],        
);

$product = array(                
	'idProduct' => $dat['id'],                
	'code' => $dat['productCode'],                
	'productRef' => $dat['productRef'],                
	'name' => $dat['productRef'],                
	'unit' => 'gramos',                
	'currencySymbol' => '$',                
	'description' => $dat['productRef'],                
	'idBrand' => $dat['generico'],                
	'brand' => $dat['brand'],                
	'idCategory' => $dat['grupo'],                
	'categoryName' => $dat['categoryName'],                
	'idSubcategory' => $dat['subgrupo'],                
	'subcategoryName' => $dat['subcategoryName'],                
	'idLine' => $dat ['codigo_linea'],                
	'lineName' => $dat['linea'],                
	'supplierName' => $dat['SupplierName'],                
	'price' => round(($dat['valor_unitario']), 2),                
	'tax' => $dat['porcentaje_iva'],                
	'discountPrice' => '0',                
	'state' => $state            
);

$cartera = [              
	'idCustomer' => $inf['id'],              
	'invoiceNumber' => $inf['Tipo']."-".$inf['numero_factura'],              
	'totalValue' => round(($inf['valor_total']), 2),              
	'balance' => round(($inf['Saldo']), 2),              
	'taxValue' => round(($inf['iva']), 2),              '
	createDate' =>$this->limpiarFecha( $inf['fecha_creacion']),              
	'dueDate' => $this->limpiarFecha($inf['fecha_vencimiento'])            
];