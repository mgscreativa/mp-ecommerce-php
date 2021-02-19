<?php
require __DIR__  . '/vendor/autoload.php';
require __DIR__  . '/utils.php';

// MercadoPago\SDK::setPublicKey('TEST-ca2526ee-ae67-4e72-b396-9925a99027dc');
MercadoPago\SDK::setAccessToken('TEST-3948326050459081-081708-870f29025b3f994640965ff78b564288__LA_LD__-225562264');
// MercadoPago\SDK::setAccessToken('TEST-6317427424180639-090914-d7e31028329ff046e873fae82ed7b93c-469485398');
MercadoPago\SDK::setIntegratorId("dev_af7a97de769011ea97f30242ac130004");

$preference = new MercadoPago\Preference();
$preference->external_reference = 'ABCD1234';

$items = array();
foreach($_POST['products'] as $product) {
    $product = json_decode($product);

    $item = new MercadoPago\Item();
    $item->id = '1234-' . $product->productId;
    $item->title = $product->productName;
    $item->description = 'Dispositivo móvil de Tienda e-commerce';
    $item->picture_url = $product->productImage;
    $item->quantity = 1;
    $item->unit_price = $product->productPrice;

    array_push($items, $item);
}
$preference->items = $items;

$payer = new MercadoPago\Payer();
$payer->name = "Lalo";
$payer->surname = "Landa";
$payer->email = "test_user_63274575@testuser.com";
$payer->date_created = date('c');
$payer->phone = array(
    "area_code" => "011",
    "number" => "2222-3333"
);
$payer->identification = array(
    "type" => "DNI",
    "number" => "22.333.444"
);
$payer->address = array(
    "street_name" => "Falsa",
    "street_number" => 123,
    "zip_code" => "1111"
);
$preference->payer = $payer;


$preference->back_urls = array(
    "success" => getURL() . "/process-response.php",
    "failure" => getURL() . "/process-response.php",
    "pending" => getURL() . "/process-response.php",
);
$preference->notification_url= getURL() . "/process-response.php";
$preference->auto_return = "approved";

$preference->payment_methods = array(
    "excluded_payment_methods" => array(
        array("id" => "amex"),
    ),
    "excluded_payment_types" => array(
        array("id" => "atm"),
    ),
    "installments" => 6
);

$preference->save();

//var_dump($preference->toArray()); die();
?>

<!DOCTYPE html>
<html class="supports-animation supports-columns svg no-touch no-ie no-oldie no-ios supports-backdrop-filter as-mouseuser" lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=1024">
    <title>Tienda e-commerce</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="screen, print">

    <link rel="stylesheet" href="<?php echo getURL(); ?>/assets/category-landing.css" media="screen, print">
    <link rel="stylesheet" href="<?php echo getURL(); ?>/assets/category.css" media="screen, print">
    <link rel="stylesheet" href="<?php echo getURL(); ?>/assets/merch-tools.css" media="screen, print">
    <link rel="stylesheet" href="<?php echo getURL(); ?>/assets/custom-overrides.css" media="screen, print">

    <style>
        .as-filter-button-text {
            font-size: 26px;
            font-weight: 700;
            color: #333;
        }
        .row.as-fixed-nav {
            border-bottom: 1px solid #ddd;
        }
        .as-producttile-tilehero.with-paddlenav.with-paddlenav-onhover {
            height: 330px;
        }
        .as-footnotes {
            background: #333;
            color: #fff;
            padding: 16px 40px;
        }

        .mercadopago-button {
            padding: 0 1.7142857142857142em;
            font-family: "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875em;
            line-height: 2.7142857142857144;
            background: #009ee3;
            border-radius: 0.2857142857142857em;
            color: #fff;
            cursor: pointer;
            border: 0;
        }
    </style>
    <style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style></head>



<body class="as-theme-light-heroimage">

<div class="stack">

    <div class="as-search-wrapper" role="main">
        <div class="as-navtuck-wrapper">
            <div class="as-l-fullwidth  as-navtuck" data-events="event52">
                <div>
                    <div class="pd-billboard pd-category-header">
                        <div class="pd-l-plate-scale">
                            <div class="pd-billboard-background">
                                <img src="<?php echo getURL(); ?>/assets/music-audio-alp-201709" alt="" width="1440" height="320" data-scale-params-2="wid=2880&amp;hei=640&amp;fmt=jpeg&amp;qlt=95&amp;op_usm=0.5,0.5&amp;.v=1503948581306" class="pd-billboard-hero ir">
                            </div>
                            <div class="pd-billboard-info">
                                <h1 class="pd-billboard-header pd-util-compact-small-18">Tienda e-commerce</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="as-search-results as-filter-open as-category-landing as-desktop" id="as-search-results">

            <div id="accessories-tab" class="as-accessories-details">
                <div class="as-accessories" id="as-accessories">
                    <div class="as-accessories-header">
                        <div class="as-search-results-count">
                            <span class="as-search-results-value"></span>
                        </div>
                    </div>
                    <div class="as-searchnav-placeholder" style="height: 77px;">
                        <div class="row as-search-navbar" id="as-search-navbar" style="width: auto;">
                            <div class="as-accessories-filter-tile column large-6 small-3">
                                <h2 class=" as-filter-button-text">Finalizar Compra</h2>
                            </div>
                        </div>
                    </div>
                    <div class="as-accessories-results  as-search-desktop">
                        <div class="width:60%">

                            <div class="as-producttile-info" style="float:left;min-height: 168px;">
                                <div class="as-producttile-titlepricewraper" style="min-height: 128px;">
                                    <div class="as-producttile-title">
                                        <h3 class="as-producttile-name">
                                            <p class="as-producttile-tile">
                                                <span data-ase-truncate="2">Para finalizar la compra haga click en el boton <i>Pagar la compra</i></span>
                                            </p>

                                        </h3>
                                    </div>

                                </div>
                                <form action="<?php echo getURL(); ?>/process-response.php" method="post">
<!--                                    <script-->
<!--                                        src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"-->
<!--                                        data-preference-id="--><?php //echo$preference->id; ?><!--"-->
<!--                                        data-button-label="Pagar la compra"-->
<!--                                        data-elements-color="#2D3277"-->
<!--                                        data-header-color="#fff"-->
<!--                                    ></script>-->

                                    <script src="https://beta-sdk.mercadopago.com/js/v2"></script>
                                    <script>
                                        const public_key_MLA = 'TEST-ca2526ee-ae67-4e72-b396-9925a99027dc';

                                        const mp = new MercadoPago(public_key_MLA, {
                                            locale: 'es-AR'
                                        });

                                        const options = {
                                            preference: {
                                                id: '<?php echo $preference->id; ?>',
                                            },
                                        };

                                        const checkout = mp.checkout(options);

                                        jQuery(document).ready(() => {
                                            jQuery('.mercadopago-button').on('click', () => {
                                                checkout.open();
                                            });
                                        });
                                    </script>

                                    <button type="button" class="mercadopago-button" formmethod="post">Pagar la compra</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="alert" class="as-loader-text ally" aria-live="assertive"></div>
    <div class="as-footnotes">
        <div class="as-footnotes-content">
            <div class="as-footnotes-sosumi">
                Todos los derechos reservados Tienda Tecno 2019
            </div>
        </div>
    </div>
</div>
</body>
</html>
