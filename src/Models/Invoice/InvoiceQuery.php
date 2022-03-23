<?php


/** @noinspection PhpPropertyOnlyWrittenInspection */

namespace PlisioPhpSdk\Models\Invoice;

use InvalidArgumentException;
use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Utility\StringUtil;
use ReflectionClass;
use Webmozart\Assert\Assert;

class InvoiceQuery
{
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

    public function __construct(
        string $currency,
        string $orderName,
        string $orderNumber
    ) {
        Assert::notEmpty($currency);
        Assert::inArray($currency, Currencies::asArray());
        Assert::notEmpty($orderNumber);
        Assert::notEmpty($orderNumber);

        $this->currency = $currency;
        $this->orderName = $orderName;
        $this->orderNumber = $orderNumber;
    }

    public function setAmount(string $amount): InvoiceQuery
    {
        $this->amount = $amount;

        return $this;
    }

    public function setSourceCurrency(string $sourceCurrency): InvoiceQuery
    {
        $this->sourceCurrency = $sourceCurrency;

        return $this;
    }

    public function setSourceAmount(string $sourceAmount): InvoiceQuery
    {
        $this->sourceAmount = $sourceAmount;

        return $this;
    }

    public function setAllowedPsyscids(string $allowedPsyscids): InvoiceQuery
    {
        $this->allowedPsyscids = $allowedPsyscids;

        return $this;
    }

    public function setDescription(string $description): InvoiceQuery
    {
        $this->description = $description;

        return $this;
    }

    public function setCallBackUrl(string $callBackUrl): InvoiceQuery
    {
        $this->callBackUrl = $callBackUrl;

        return $this;
    }

    public function setEmail(string $email): InvoiceQuery
    {
        $this->email = $email;

        return $this;
    }

    public function setLanguage(string $language): InvoiceQuery
    {
        $this->language = $language;

        return $this;
    }

    public function setPlugin(string $plugin): InvoiceQuery
    {
        $this->plugin = $plugin;

        return $this;
    }

    public function setVersion(string $version): InvoiceQuery
    {
        $this->version = $version;

        return $this;
    }

    public function setRedirectToInvoice(bool $redirectToInvoice): InvoiceQuery
    {
        $this->redirectToInvoice = $redirectToInvoice;

        return $this;
    }

    public function setExpireMin(string $expireMin): InvoiceQuery
    {
        $this->expireMin = $expireMin;

        return $this;
    }

    public function toArray(): array
    {
        $required = [
            'currency' => $this->currency,
            'order_name' => $this->orderName,
            'order_number' => $this->orderNumber
        ];

        $optional = [];
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            $property->setAccessible(true);
            $type = $property->getType();
            if ((null !== $type) && $type->allowsNull() && null !== $value = $property->getValue($this)) {
                $optional[StringUtil::camelToSnake($property->getName())] = $value;
            }
        }
        if (count($optional) > 0) {
            $required = array_merge($required, $optional);
        }

        return $required;
    }
}
