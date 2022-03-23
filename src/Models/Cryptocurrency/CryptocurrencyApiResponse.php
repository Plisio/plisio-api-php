<?php

namespace PlisioPhpSdk\Models\Cryptocurrency;

class CryptocurrencyApiResponse
{
    private string $status;
    private array $paysysArr;

    public function __construct(string $status, array $paysysArray)
    {
        $this->status = $status;
        $this->paysysArr = $paysysArray;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPaysysArr(): array
    {
        return $this->paysysArr;
    }
}
