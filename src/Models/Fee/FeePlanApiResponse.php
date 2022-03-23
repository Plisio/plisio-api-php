<?php

namespace PlisioPhpSdk\Models\Fee;

use InvalidArgumentException;
use PlisioPhpSdk\Common\Enum\FeePlans;

class FeePlanApiResponse
{
    private string $status;
    private array $feePlanItems;

    public function __construct(string $status, array $feePlanItems)
    {
        $this->status = $status;
        $this->feePlanItems = $feePlanItems;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFeePlanItems(): array
    {
        return $this->feePlanItems;
    }

    public function getFeePlanItemByKey(string $key): FeePlanItem
    {
        if (!in_array($key, FeePlans::asArray())) {
            throw new InvalidArgumentException("Unsupported key: '$key'");
        }
        if (!array_key_exists($key, $this->feePlanItems)) {
            throw new InvalidArgumentException("Key: '$key' does not exists in fee-plan items");
        }

        return $this->feePlanItems[$key];
    }
}
