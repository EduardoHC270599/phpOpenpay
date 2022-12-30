<?php

use Openpay\Data\Openpay;
use Openpay\Data\OpenpayApiAuthError;
use Openpay\Data\OpenpayApiConnectionError;
use Openpay\Data\OpenpayApiError;
use Openpay\Data\OpenpayApiRequestError;
use Openpay\Data\OpenpayApiTransactionError;

require(dirname(__FILE__).'../Openpay/Openpay.php');

$openpay = Openpay::getInstance('mk5dcrg2zbdmliypqgpf', 'sk_94baaf89f6614068a61869ede2c41bbe', 'MX');

$ban = $_POST['ban'];

if ($ban==="c1") {
    # code...
    $dataCard = json_decode($_POST['arrayDatosTarjeta']);
    $token_id = $dataCard[0];
    $Device = $dataCard[1];   
    //Creando EMPLEADO
    $customerData = array(
        'name' => 'Teofilo',
        'last_name' => 'Velazco',
        'email' => 'teofilo@payments.com',
        'phone_number' => '4421112233');    
    $customer = $openpay->customers->add($customerData);
    $empleadoId = $customer->id;     
    // AGREGAR TARETA AL CLIENTE
    $cardDataDos = array(
        'token_id' => $token_id,
        'device_session_id' => $Device        
    );        
    $customer = $openpay->customers->get($empleadoId);
    $card2 = $customer->cards->add($cardDataDos);
    $tarjetaId2 = $card2->id;
    //CARGO A CLIENTE
    $chargeRequest = array(
        'method' => 'card',
        'source_id' => $tarjetaId2,
        'amount' => 100,
        'currency' => 'MXN',
        'description' => 'Cargo inicial a mi merchant',
        'order_id' => 'oid-0009',
        'device_session_id' => $Device);
    //Obteniendo Empleado
    $customer = $openpay->customers->get($empleadoId);

    $Cargoo = $customer->charges->create($chargeRequest);
    $CardoId = $Cargoo->id;
    
    //Obteniendo el estatus del cargo
    $charge = $customer->charges->get($CardoId);
    $status = $charge->status;
    $d = [1,2,3,4];
    if($status == 'completed'){
        echo true;
    }else{
        echo false;
    }  
}else{
// Crear una EMPLEADO************************************-------------PARTO 2---------------------********************************
$customerData = array(
	'name' => 'Teofilo',
	'last_name' => 'Velazco',
	'email' => 'teofilo@payments.com',
	'phone_number' => '4421112233');

$customer = $openpay->customers->add($customerData);
$empleadoId = $customer->id;
// echo($empleado);

// $customer = $openpay->customers->get('ay2ckrnfcpg8qzxhf0hj');
// var_dump($customer);

// Crear una tarjeta************************************----------------------------------********************************
$cardData = array(
	'holder_name' => 'Luis Pérez',
	'card_number' => '4111111111111111',
	'cvv2' => '123',
	'expiration_month' => '12',
	'expiration_year' => '24'
	);

$card = $openpay->tokens->add($cardData);
$tarjetaId = $card->id;
// echo($tarjeta);

// Agregar tarjeta a Cliente************************************----------------------------------********************************
$cardDataDos = array(
	'token_id' => $tarjetaId,
	'device_session_id' => '8VIoXj0hN5dswYHQ9X1mVCiB72M7FY9o'
    
);

$customer = $openpay->customers->get($empleadoId);
$card2 = $customer->cards->add($cardDataDos);
$tarjetaId2 = $card2->id;
// echo($tarjeta2);

// Cargo a Cliente************************************----------------------------------********************************
$chargeRequest = array(
    'method' => 'card',
    'source_id' => $tarjetaId2,
    'amount' => 100,
    'currency' => 'MXN',
    'description' => 'Cargo inicial a mi merchant',
    'order_id' => 'oid-00s705s1',
    'device_session_id' => 'kR1MiQhz2otdIuUlQkbEyitIqVMiI16f');

  $customer->charges->create($chargeRequest);
}
?>
