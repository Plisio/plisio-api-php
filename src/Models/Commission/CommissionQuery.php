<?php

namespace PlisioPhpSdk\Models\Commission;

use Exception;
use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Common\Enum\FeePlans;
use PlisioPhpSdk\Common\Enum\OperationType;
use Webmozart\Assert\Assert;

class CommissionQuery
{
    private string $psyscid;

    private ?string $addresses = null;
    private ?string $amounts = null;
    private ?string $type = null;
    private ?string $feePlan = null;

    /**
     * @throws Exception
     */
    public function __construct(string $psyscid)
    {
        Assert::notEmpty($psyscid);
        Assert::inArray($psyscid, Currencies::asArray());

        $this->psyscid = $psyscid;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function setAddresses(string $addresses): self
    {
        Assert::notEmpty($addresses);
        $this->addresses = $addresses;

        return $this;
    }

    public function setAmounts(string $amounts): self
    {
        Assert::notEmpty($amounts);
        $this->amounts = $amounts;

        return $this;
    }

    public function setType(string $type): self
    {
        Assert::notEmpty($type);
        Assert::inArray($type, OperationType::asArray());

        $this->type = $type;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function setFeePlan(string $feePlan): self
    {
        Assert::inArray($feePlan, FeePlans::asArray());
        $this->feePlan = $feePlan;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if (null !== $this->feePlan) {
            $data['feePlan'] = $this->feePlan;
        }
        if (null !== $this->amounts) {
            $data['amounts'] = $this->amounts;
        }
        if (null !== $this->addresses) {
            $data['addresses'] = $this->addresses;
        }
        if (null !== $this->type) {
            $data['type'] = $this->type;
        }

        return $data;
    }
}
