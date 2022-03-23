<?php

namespace PlisioPhpSdk\Models\Fee;

class FeeResponse
{
    private string $fee;
    private string $psyscid;
    private string $currency;
    private string $plan;

    public function __construct(string $fee, string $psyscid, string $currency, string $plan)
    {
        $this->fee = $fee;
        $this->psyscid = $psyscid;
        $this->currency = $currency;
        $this->plan = $plan;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }
}
