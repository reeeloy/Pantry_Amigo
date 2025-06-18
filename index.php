<?php

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

require 'vendor/autoload.php';

MercadoPagoConfig::setAccessToken('APP_USR-4306942363216817-061310-05528330eb0be839b7b575acd647667e-2496822952');

$client = new PreferenceClient();
$preference = $client->create([
    "items" => [
        [
            "id" => "donacion_12345",
            "title" => "Donación para caso #12345",
            "quantity" => 1,
            "unit_price" => 3000.00,
        ],

    ],

    "statement_descriptor" => "Donación Pantry",
    "external_reference" => "donacion_12345",
    
]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>base para MP</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
        
      <div id="wallet_container">
        <script>
            const mp = new MercadoPago('APP_USR-8cf87360-1878-4484-be17-19415e2931e7', {
                locale: 'es-CO'
            });

            mp.bricks().create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: '<?php echo $preference->id; ?>',
                    redirectMode: 'modal'
                },
                customization: {
                    texts: {
                        action: 'buy',
                        valueProp: 'security_details',
                    },
                    visual: {
                        buttonBackground: 'black',
                    }
                }
            })

        
        </script>
      </div>
</body>
</html>