<?php

namespace PlisioPhpSdk\Models\Fee;

class FeePlanItem
{
    private ?int $confTarget;
    private int $feeRate;
    private string $dynamicField;
    private string $plan;
    private string $unit;
    private ?string $value;

    public function __construct(
        ?int $confTarget,
        int $feeRate,
        string $dynamicField,
        string $plan,
        string $unit,
        ?string $value
    ) {
        $this->confTarget = $confTarget;
        $this->feeRate = $feeRate;
        $this->dynamicField = $dynamicField;
        $this->plan = $plan;
        $this->unit = $unit;
        $this->value = $value;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['conf_target'],
            $data['feeRate'],
            $data['dynamicField'],
            $data['plan'],
            $data['unit'],
            $data['value']
        );
    }

    public function getConfTarget(): ?int
    {
        return $this->confTarget;
    }

    public function getFeeRate(): int
    {
        return $this->feeRate;
    }

    public function getDynamicField(): string
    {
        return $this->dynamicField;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
