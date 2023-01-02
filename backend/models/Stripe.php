<?php

    function checkout($data) {
        require './stripe-php-master/init.php';
        \Stripe\Stripe::setVerifySslCerts(false);
        \Stripe\Stripe::setApiKey('sk_test_51Ju3hUClfndKyCAFnxGe82rwVvqJSv2s39pwHhCdJAamXViyZMYUrU0ERdxj7YL0ytRRwDFUmqutUggEzmqZGCoj00HKvO6xEO');

        // header('Content-Type: application/json');
        $YOUR_DOMAIN = 'https://expertwebtest.dev/cartridgeextra/';
        $line_items = array();
        $delivery_options = ['free', 'standard', 'express'];
        $shipping_rate = '';
        
        for ($i=0; $i < sizeof($data); $i++) { 
            $item = array(
                'price_data' => [
                    'currency' => 'aud',
                    'unit_amount' => $data[$i]->prod_sell_price,
                    'product_data' => 
                        [
                        'name' => $data[$i]->prod_name
                        ],
                    ],
                'quantity' => $data[$i]->cart_item_quantity,
            );
            array_push($line_items, $item);
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],    
            'shipping_rates' => ['shr_1K1Pd7ClfndKyCAFcOmhsriF'],
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA', 'AU'],
            ],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . "checkout/{CHECKOUT_SESSION_ID}",
            'cancel_url' => $YOUR_DOMAIN . 'checkout/',
        ]);

        return ['id' => $checkout_session->id];
    }

?>

