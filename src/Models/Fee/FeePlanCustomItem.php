<?php

namespace PlisioPhpSdk\Models\Fee;

class FeePlanCustomItem
{
    private int $min;
    private int $max;
    private int $default;
    private string $borders;
    private string $unit;

    public function __construct(int $min, int $max, int $default, string $borders, string $unit)
    {
        $this->min = $min;
        $this->max = $max;
        $this->default = $default;
        $this->borders = $borders;
        $this->unit = $unit;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['min'],
            $data['max'],
            $data['default'],
            $data['borders'],
            $data['unit']
        );
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getDefault(): int
    {
        return $this->default;
    }

    public function getBorders(): string
    {
        return $this->borders;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}
