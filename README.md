## Plisio PHP API library

To start using cryptocurrencies on your site you need to create an account on <https://plisio.net> and approve your domain under API setting page to get a **secret key**.

This secret key will be used for creating instance of the PlisioClient.

### Installation

**Composer**

You can install library via [Composer](http://getcomposer.org/). Run the following command in your terminal:

```bash
composer require plisio/plisio-api-php
```

Usage example:

```
$secretKey = 'xxxxx';

$plisio = new \Plisio\ClientAPI($secretKey);
$plisio->getBalances('BTC');
```

New order:

```
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$secretKey = 'xxxxx';
$request = [
          'amount' => float, // required Invoice amount in selected currency OR amount_usd can be used instead
//          'amount_usd' => float, // required Invoice amoint in USD
          'currency' => string, // required (ETH, BTC, LTC, TZEC, DOGE, BCH, ...)
          'order_number' => string, // required Client's internal ID
          'order_name' => string, // required Client's internal name
          'description' => string, // optional any description
          'callback_url' => string, // optional Absolute URL where Plisio will send updates
          'success_url' => string, // optional Absolute URL of the final (success) invoice link
          
];

$plisio = new \Plisio\ClientAPI($secretKey);
$invoice = $plisio->createTransaction($request);

if ($invoice && isset($invoice['status']) && $invoice['status'] == 'success') {
   header('Location: ' . $invoice['data']['invoice_url']);
} else {
  print_r($invoice);
}
```
