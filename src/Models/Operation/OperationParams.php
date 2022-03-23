<?php

namespace PlisioPhpSdk\Models\Operation;

use PlisioPhpSdk\Models\Fee\FeeParams;

class OperationParams
{
    private FeeParams $feeParams;
    private string $orderNumber;
    private string $orderName;
    private string $description;
    private string $sourceAmount;
    private string $sourceCurrency;
    private string $value;
    private string $avatar;
    private string $store;
    private string $currency;
    private string $psyscid;
    private string $amount;
    private string $sourceRate;

    public function __construct(
        FeeParams $feeParams,
        string $orderNumber,
        string $orderName,
        string $description,
        string $sourceAmount,
        string $sourceCurrency,
        string $value,
        string $avatar,
        string $store,
        string $currency,
        string $psyscid,
        string $amount,
        string $sourceRate
    ) {
        $this->feeParams = $feeParams;
        $this->orderNumber = $orderNumber;
        $this->orderName = $orderName;
        $this->description = $description;
        $this->sourceAmount = $sourceAmount;
        $this->sourceCurrency = $sourceCurrency;
        $this->value = $value;
        $this->avatar = $avatar;
        $this->store = $store;
        $this->currency = $currency;
        $this->psyscid = $psyscid;
        $this->amount = $amount;
        $this->sourceRate = $sourceRate;
    }

    public function getFeeParams(): FeeParams
    {
        return $this->feeParams;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function getOrderName(): string
    {
        return $this->orderName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSourceAmount(): string
    {
        return $this->sourceAmount;
    }

    public function getSourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getStore(): string
    {
        return $this->store;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getSourceRate(): string
    {
        return $this->sourceRate;
    }
}
