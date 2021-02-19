<?php
// https://it.mgscreativa.com.ar/mp-ecommerce-php/process-response.php?collection_id=6376222942&collection_status=approved&preference_id=225562264-f3372b7e-8cfd-4518-8e06-2a2da7eafb8b&external_reference=L63X04&payment_type=credit_card&merchant_order_id=1305753863
// https://it.mgscreativa.com.ar/mp-ecommerce-php/process-response.php?id=6376088157&topic=payment

ini_set('xdebug.var_display_max_depth', '-1');
ini_set('xdebug.var_display_max_children', '-1');
ini_set('xdebug.var_display_max_data', '-1');

require __DIR__  . '/vendor/autoload.php';
require __DIR__  . '/utils.php';

$testAccessToken = 'TEST-3948326050459081-081708-870f29025b3f994640965ff78b564288__LA_LD__-225562264';
$productionAccessToken = 'APP_USR-3948326050459081-081708-dedd16c590a2e9e8064b97ef284cdf46__LC_LD__-225562264';

MercadoPago\SDK::setAccessToken($productionAccessToken);
MercadoPago\SDK::setIntegratorId("dev_af7a97de769011ea97f30242ac130004");

$preference = new MercadoPago\Preference();
$preference->external_reference = 'L63X04';

$item = new MercadoPago\Item();
$item->id = 'Order Number: L63X04 - Order ID: 2';
$item->title = 'MP PHP SDK - L63X04';
$item->description = 'MP PHP SDK - L63X04';
$item->quantity = 1;
$item->unit_price = 100;
$item->currency_id = 'ARS';
$item->picture_url = 'https://it.mgscreativa.com.ar/j39vm36/images/virtuemart/vendor/vendor.gif';

$items = array();
array_push($items, $item);
$preference->items = $items;

$payer = new MercadoPago\Payer();
$payer->name = 'Lalo';
$payer->surname = 'Landa';
$payer->email = 'test_user_74413957@testuser.com';
$payer->date_created = date('c');
$payer->phone = array(
    "area_code" => '011',
    "number" => '2222-3333'
);
$payer->identification = array(
    "type" => 'DNI',
    "number" => '22.333.444'
);
$payer->address = array(
    "street_name" => 'Falsa',
    "street_number" => 123,
    "zip_code" => '1111'
);
$preference->payer = $payer;

$shipments= new MercadoPago\Shipments();
$shipments->mode = 'me2';
$shipments->dimensions = '10x5x3,500';
$shipments->local_pickup = false;
$shipments->receiver_address = array(
    "zip_code" => 1605,
);
$shipments->default_shipping_method = 504245;
$shipments->zip_code = 1605;
$preference->shipments = $shipments;

$preference->back_urls = array(
    "success" => getURL() . '/process-response.php',
    "failure" => getURL() . '/process-response.php',
    "pending" => getURL() . '/process-response.php',
);

$preference->notification_url = getURL() . '/process-response.php';
$preference->auto_return = 'approved';

$preference->payment_methods = array(
    'excluded_payment_methods' => array(
        array('id' => 'amex'),
    ),
    'excluded_payment_types' => array(
        array('id' => 'atm'),
    ),
    'installments' => 6
);

$result = null;
$titulo = 'OK';
try {
    if(!$preference->save()) {
        $result = $preference->error;
        $titulo = 'Error Recuperable';
    }
} catch (Exception $e) {
    $result = $e;
    $titulo = 'Error';
}

echo '<h1>Preferencia</h1>';
echo '<pre>' . highlight_string("<?php\n" . var_export($preference->toArray(), true) . ";\n?>") . '</pre>';
echo '<h1>Resultado: ' . $titulo . '</h1>';
echo '<pre>' . highlight_string("<?php\n" . var_export($result, true) . ";\n?>") . '</pre>';

echo '<h1>Fuente PHP</h1>';
show_source(__FILE__);
