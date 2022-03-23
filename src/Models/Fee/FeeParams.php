<?php

namespace PlisioPhpSdk\Models\Fee;

class FeeParams
{
    private ?string $confTarget;
    private ?string $plan;
    private ?string $value;

    public function __construct(?string $confTarget, ?string $plan, ?string $value)
    {
        $this->confTarget = $confTarget;
        $this->plan = $plan;
        $this->value = $value;
    }

    public function getConfTarget(): ?string
    {
        return $this->confTarget;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
