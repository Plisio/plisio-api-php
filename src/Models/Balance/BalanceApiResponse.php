<?php

namespace PlisioPhpSdk\Models\Balance;

class BalanceApiResponse
{
    private string $status;
    private array $balanceResponseCollection;

    public function __construct(string $status, array $balanceResponseCollection)
    {
        $this->status = $status;
        $this->balanceResponseCollection = $balanceResponseCollection;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getBalanceResponseCollection(): array
    {
        return $this->balanceResponseCollection;
    }
}
