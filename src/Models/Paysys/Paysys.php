<?php

namespace PlisioPhpSdk\Models\Paysys;

class Paysys
{
    private string $name;
    private string $cid;
    private string $currency;
    private string $icon;
    private string $rateUsd;
    private string $priceUsd;
    private string $precision;
    private string $fiat;
    private string $fiatRate;
    private string $minSumIn;
    private string $invoiceCommissionPercentage;
    private ?int $hidden;
    private ?bool $maintenance;

    public function __construct(
        string $name,
        string $cid,
        string $currency,
        string $icon,
        string $rateUsd,
        string $priceUsd,
        string $precision,
        string $fiat,
        string $fiatRate,
        string $minSumIn,
        string $invoiceCommissionPercentage,
        ?int $hidden,
        ?bool $maintenance
    ) {
        $this->name = $name;
        $this->cid = $cid;
        $this->currency = $currency;
        $this->icon = $icon;
        $this->rateUsd = $rateUsd;
        $this->priceUsd = $priceUsd;
        $this->precision = $precision;
        $this->fiat = $fiat;
        $this->fiatRate = $fiatRate;
        $this->minSumIn = $minSumIn;
        $this->invoiceCommissionPercentage = $invoiceCommissionPercentage;
        $this->hidden = $hidden;
        $this->maintenance = $maintenance;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCid(): string
    {
        return $this->cid;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getRateUsd(): string
    {
        return $this->rateUsd;
    }

    public function getPriceUsd(): string
    {
        return $this->priceUsd;
    }

    public function getPrecision(): string
    {
        return $this->precision;
    }

    public function getFiat(): string
    {
        return $this->fiat;
    }

    public function getFiatRate(): string
    {
        return $this->fiatRate;
    }

    public function getMinSumIn(): string
    {
        return $this->minSumIn;
    }

    public function getInvoiceCommissionPercentage(): string
    {
        return $this->invoiceCommissionPercentage;
    }

    public function getHidden(): ?int
    {
        return $this->hidden;
    }

    public function isMaintenance(): ?bool
    {
        return $this->maintenance;
    }
}
