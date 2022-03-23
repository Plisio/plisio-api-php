#This PHP SDK project for Plisio Api Support

This is fully object-oriented php's composer package, developed to work with
Plisio's cryptocurrency payment-gateway.

```php
interface InteractionInterface
{
    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return BalanceApiResponse on success
     */
    public function getBalance(string $currency): ?BalanceApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return OperationApiResponse on success
     */
    public function getOperationById(string $id): ?OperationApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return CommissionApiResponse on success
     */
    public function getCommission(CommissionQuery $query): ?CommissionApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return CryptocurrencyApiResponse on success
     */
    public function getCurrencyInfoByFiat(string $fiat): ?CryptocurrencyApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return FeePlanApiResponse on success
     */
    public function getFeePlanByPsyscid(string $psyscid): ?FeePlanApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return WithdrawApiResponse on success
     */
    public function withdraw(WithdrawQuery $withdrawQuery): ?WithdrawApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return InvoiceWhiteLabelResponse on success
     */
    public function createInvoice(InvoiceQuery $invoiceQuery): ?InvoiceWhiteLabelResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return FeeApiResponse on success
     * @return null on errors (If silent mode turn on)
     */
    public function getFee(FeeQuery $feeQuery): ?FeeApiResponse;
}
```

**_InteractionInterface_** methods description:

1. **_getBalance(string $currency)_**

   Let's see yourself cryptocurrency **balance** in *Bitcoin (BTC)*, for example.
   Also supports 9 [cryptocurrencies](https://plisio.net/documentation/appendices/supported-cryptocurrencies).

   <code>$balance = $this->interaction->getBalance(Currencies::BTC);</code>
2. **_getOperationById(string $id)_**
   
   Returns information about concrete transaction by transaction identifier, example:
   
   <code>$operation = $this->interaction->getOperationById('61e9384388ecfd3ea775dfb2');</code>
3. **_getCommission(CommissionQuery $query)_**

   Estimates cryptocurrency fee and Plisio commission, accepts CommissionQuery class, example:

   <code>$commission = $this->interaction->getCommission(new CommissionQuery(Currencies::BTC));</code>
   
   Also commission query class has nullable parameters:
   ```php
    private ?string $addresses = null;
    private ?string $amounts = null;
    private ?string $type = null;
    private ?string $feePlan = null;
   ```
   + <code>$addresses</code> - Wallet address or comma separated addresses when estimating fee for mass withdrawal
   + <code>$amounts</code> - Amount or comma separated amount that will be sent in case of mass withdraw
   + <code>$type</code> - Operation type, such as: 'cash_out' or 'mass_cash_out'
   + <code>$feePlan</code> - The name of [fee plan](https://plisio.net/documentation/endpoints/fee-plans)
   
4. **_getCurrencyInfoByFiat(string $fiat)_**

    Provides current rate of exchange supported cryptocurrencies to
    [the definite fiat currency](https://plisio.net/documentation/appendices/supported-fiat-currencies),
    needs to send the request to API by the method with selected fiat currency.

    Let's get the rate of *Australian Dollar (AUD)*, for instance. By the way,
    if there is not selected any of fiat currency, is rate of
    *United States Dollar (USD)*, by default. **The response** is a list of models
    that consist rates of exchanges:

    <code>$info = $this->interaction->getCurrencyInfoByFiat(FiatCurrencies::AUD);</code>
5. **_getFeePlanByPsyscid(string $psyscid)_**

    Returns the model with [fee plans](https://plisio.net/documentation/endpoints/fee-plans)
    by selected <code>cryptocurrency</code>. Also, this model has additional fields
    pointed what your fee plan is.

    Example:

    <code>$feePlan = $this->interaction->getFeePlanByPsyscid(Currencies::BTC);</code>
6. **_withdraw(WithdrawQuery $withdrawQuery)_**
   If you want to withdraw, you should call <code>withdraw</code> method that accepts WithdrawQueryClass:
   ```php
    private string $psyscid;
    private string $to;
    private string $amount;
    private int $feeRate;
    private string $feePlan;

    private ?string $type = null;
   ```
   + <code>$psyscid</code> — a name of cryptocurrency;
   + <code>$to</code> — hash or multiple comma separated hashes pooled for the *mass_cash_out*;
   + <code>$amount</code> — any comma separated float values for the *mass_cash_out*
     in the order that hashes are in <code>to</code> parameter;
   + <code>$feePlan</code> — a name of the one of
     [fee plans](https://plisio.net/documentation/endpoints/fee-plans);
   + <code>$feeRate</code> — custom feeRate. conf_target (blocks) for BTC like
     cryptocurrencies or gasPrice in GWAI for ETH based cryptocurrencies;
   + <code>$type</code> — operation type (it's an optional parameter).

    Example:
    ```php
   $withdraw = $this->interaction->withdraw(
            new WithdrawQuery(
                Currencies::BTC,
                '2N3cD7vQxBqmHFVFrgK2o7HonHnVoFxxDVB',
                '0.00031',
                FeePlans::NORMAL,
                1
            )
        );
    ```
7. **_createInvoice(InvoiceQuery $invoiceQuery)_**

   Let us coming go to the creation of invoices, first you need to build InvoiceQuery class:
    ```php
    private string $currency;
    private string $orderName;
    private string $orderNumber;

    private ?string $amount = null;
    private ?string $sourceCurrency = null;
    private ?string $sourceAmount = null;
    private ?string $allowedPsyscids = null;
    private ?string $description = null;
    private ?string $callBackUrl = null;
    private ?string $email = null;
    private ?string $language = null;
    private ?string $plugin = null;
    private ?string $version = null;
    private ?bool $redirectToInvoice = null;
    private ?string $expireMin = null;
    ```
   The query needs to receive the next **required** parameters:
   + <code>$currency</code> — the name of cryptocurrency;
   + <code>$orderName</code> — merchant internal order name;
   + <code>$orderNumber</code> — merchant internal order number.

   Beside these params, there are **additional** such as:
   + <code>$amount</code> — any cryptocurrency float value. If you want to convert a fiat currency,
     you should skip current field and use the next two fields instead it;
   + <code>$sourceCurrency</code> — the name of the fiat currency;
   + <code>$sourceAmount</code> — any float value;
   + <code>$allowedPsyscids</code> — comma-separated list of cryptocurrencies that
     allowed for payment. Also, you will be able to select one of them. Example: *'BTC,ETH,TZEC'*;
   + <code>$description</code> — merchant invoice description;
   + <code>$callbackUrl</code> — merchant full URL to get invoice updates.
     The *POST* request will be sent to this URL. If this parameter isn’t set,
     a callback will be sent to URL that can be set under profile in API settings,
     that has got 'Status URL' field;
   + <code>$email</code> — an autofill invoice email.
     You will be asked to insert their email where a notification will be sent;
   + <code>$language</code> — en_US (now supports English only);
   + <code>$plugin</code> — Plisio’s internal field to determine integration plugin;
   + <code>$version</code> — Plisio’s internal field to determine integration plugin version.
    
    Example:
    ```php
   $invoice = $this->interaction->createInvoice(
            (new InvoiceQuery(Currencies::BTC, 'some order', '234sdfsd'))
                ->setAmount('0.01')
        );
    ```
8. **_getFee(FeeQuery $feeQuery)_**

    To estimate fee you should create FeeQuery class with parameters:
    ```php
    private string $psyscid;
    private string $addresses;
    private string $amounts;

    private ?string $feePlan = null;
    ```
   + <code>$psyscid</code> — a name of cryptocurrency;
   + <code>$addresses</code> — wallet address or comma separated addresses
     when estimating fee for mass withdrawal;
   + <code>$amounts</code> — amount or comma separated amount
     that will be sent in case of mass withdraw;
   + <code>$feePlan</code> — a name of the one of
     [fee plans](https://plisio.net/documentation/endpoints/fee-plans)
     (it is not required).

    Example:
    ```php
   $fee = $this->interaction->getFee(
            new FeeQuery(
                Currencies::BTC,
                'tb1qfqtvgh97umdum8zwyah4ztzkwz8j7qyyalgwa4',
                '0.0003'
            )
        );
    ```

Entrypoint oh php's sdk is represented with singleton-class **_PlisioPhpSdk_**, example:
```php
$container = \PlisioPhpSdk\PlisioPhpSdk::get();
/** @var \PlisioPhpSdk\Http\InteractionInterface $interaction */
$interaction = $container->get(\PlisioPhpSdk\Http\InteractionInterface::class);
```
Also, this sdk's provides suitable configuration possibility, you can create **_conf.yaml_** file like below:
```yaml
plisio-php-sdk:
  common:
    dev:
      api-key:
      base-uri:
      user: 
      password: 
    prod:
      api-key:
      base-uri:
  current-env: dev
  silent: false
```
To configure sdk's you need to create conf.yaml file in your's project-root directory and launch console command
from vendor's directory:

***php cli/console.php plisio-php-sdk:load-conf "path to conf.yaml file"***

Sdk's has two working modes from the box (***This functionality only concerns interaction with the api***):

+ ***Silent mode*** (Does not throw exception, return null in some cases), all exception writing out in .log file
+ ***Non-silent mode*** (Throws exceptions), also all exceptions are logged

The sdk is logged in the plisio-php-sdk.log log file, for convenience, you can create a symbolic link from your root directory to this file.
In the quality of the demonstration, all the functionality of the sdk (working with the test resource) is duplicated by console commands:

***plisio-php-sdk:load-conf***

***plisio-php-sdk:test-balance***         

***plisio-php-sdk:test-commission***

***plisio-php-sdk:test-create-invoice***

***plisio-php-sdk:test-currency-info***

***plisio-php-sdk:test-fee***

***plisio-php-sdk:test-fee-plan***

***plisio-php-sdk:test-operation***

***plisio-php-sdk:test-withdraw***
