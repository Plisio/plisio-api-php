<?php

namespace PlisioPhpSdk\Models\Fee;

use PlisioPhpSdk\Common\Enum\Currencies;
use Webmozart\Assert\Assert;

class FeeQuery
{
    private string $psyscid;
    private string $addresses;
    private string $amounts;

    private ?string $feePlan = null;

    public function __construct(string $psyscid, string $addresses, string $amounts)
    {
        Assert::notEmpty($psyscid);
        Assert::inArray($psyscid, Currencies::asArray());
        Assert::notEmpty($addresses);
        Assert::notEmpty($amounts);

        $this->psyscid = $psyscid;
        $this->addresses = $addresses;
        $this->amounts = $amounts;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function setFeePlan(string $feePlan): self
    {
        $this->feePlan = $feePlan;

        return $this;
    }

    public function toArray(): array
    {
        $required = [
            'addresses' => $this->addresses,
            'amounts' => $this->amounts
        ];
        if (null !== $this->feePlan) {
            $required['feePlan'] = $this->feePlan;
        }
        return $required;
    }
}
