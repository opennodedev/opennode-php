# OpenNode PHP library for API v1

[![Build Status](https://travis-ci.org/opennodedev/opennode-php.svg?branch=master)](https://travis-ci.org/opennodedev/opennode-php)

PHP library for OpenNode API.

You can sign up for a OpenNode account at <https://opennode.co> for production and <https://dev.opennode.co> for testing.

Please note, that for testing you must generate separate API credentials on <https://dev.opennode.co>. API credentials generated on <https://opennode.co> will only work in production mode.

## Composer Installation

Install library via [Composer](http://getcomposer.org/). Run the following command in your terminal:

```bash
composer require opennode/opennode-php
```

## Manual Installation

Donwload [latest release](https://github.com/opennodedev/opennode-php/releases) and include `init.php` file.

```php
require_once('/path/opennode-php/init.php');
```

## Getting Started

OpenNode PHP library instructions.

https://opennode.co/docs

### Setting up OpenNode library

#### Setting default authentication

```php
use OpenNode\OpenNode;

\OpenNode\OpenNode::config(array(
    'environment'               => 'dev', // dev OR live
    'auth_token'                => 'YOUR_AUTH_TOKEN',
    'curlopt_ssl_verifypeer'    => TRUE // default is false
));

// $order = \OpenNode\Merchant\Charge::find('c1cddabe-c27b-44a6-91e8-a8f3553dc5c7');
```

#### Setting authentication individually

```php
use OpenNode\OpenNode;

# \OpenNode\Merchant\Charge::find($orderId, $options = array(), $authentication = array())

$charge = \OpenNode\Merchant\Charge::find('c1cddabe-c27b-44a6-91e8-a8f3553dc5c7', array(), array(
    'environment' => 'dev', // dev OR live
    'auth_token' => 'YOUR_AUTH_TOKEN'));
```

### Creating Chrage

```php
use OpenNode\OpenNode;

$charge_params = array(
                   'description'       => '1x Book', //Optional
                   'amount'            => 20.00,
                   'currency'          => 'USD', //Optional
                   'order_id'          => 'YOUR-PLATFORM-ID', //Optional
                   'email'             => 'johndoe@example.com', //Optional
                   'name'              => 'John Doe', //Optional
                   'callback_url'      => 'https://site.com/?handler=opennode', //Optional
                   'success_url'       => 'https://example.com/order/abc123', //Optional
                   'auto_settle'       => false //Optional
               );

try {
  $charge = \OpenNode\Merchant\Charge::create($charge_params);

  echo 'LN BOLT11: ' . $charge->lightning_invoice->payreq;
  echo 'BTC address: ' . $charge->chain_invoice->address

  print_r($charge);
} catch (Exception $e) {
  echo $e->getMessage(); // InvalidRequest Error creating order
}
```

### Getting Charge Info

```php
use OpenNode\OpenNode;

try {
    $charge = \OpenNode\Merchant\Charge::find('c1cddabe-c27b-44a6-91e8-a8f3553dc5c7');

    if ($charge) {
      var_dump($charge);
    }
    else {
      echo 'Charge not found';
    }
} catch (Exception $e) {
  echo $e->getMessage(); // Unauthorized Not authorized: invalid api key
}
```

### Getting Paid Charges

```php
try {
  $charges = \OpenNode\Merchant\Charge::findAllPaid();

  foreach ($charges as $charge) {
    print_r($charge);
  }
} catch (Exception $e) {
  echo $e->getMessage(); // Unauthorized Not authorized: invalid api key
}
```
