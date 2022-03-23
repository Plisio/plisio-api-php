<?php

namespace PlisioPhpSdk\Models\Balance;

class BalanceResponse
{
    private string $psyscid;
    private string $balance;
    private string $currency;

    public function __construct(string $psyscid, string $balance, string $currency)
    {
        $this->psyscid = $psyscid;
        $this->balance = $balance;
        $this->currency = $currency;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
