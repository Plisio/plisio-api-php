<?php

namespace PlisioPhpSdk\Models\Withdraw;

use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Common\Enum\FeePlans;
use PlisioPhpSdk\Common\Enum\OperationType;
use Webmozart\Assert\Assert;

class WithdrawQuery
{
    private string $psyscid;
    private string $to;
    private string $amount;
    private int $feeRate;
    private string $feePlan;

    private ?string $type = null;

    public function __construct(
        string $psyscid,
        string $to,
        string $amount,
        string $feePlan,
        int $feeRate
    ) {
        Assert::notEmpty($psyscid);
        Assert::inArray($psyscid, Currencies::asArray());
        Assert::notEmpty($amount);
        Assert::notEmpty($feePlan);
        Assert::inArray($feePlan, FeePlans::asArray());
        Assert::notEmpty($to);
        Assert::notEmpty($feeRate);

        $this->psyscid = $psyscid;
        $this->to = $to;
        $this->amount = $amount;
        $this->feePlan = $feePlan;
        $this->feeRate = $feeRate;
    }

    public function setType(string $type): self
    {
        Assert::notEmpty($type);
        Assert::inArray($type, OperationType::asArray());

        $this->type = $type;
        return $this;
    }

    public function toArray(): array
    {
        $withdrawQueryData = [
            'psys_cid' => $this->psyscid,
            'feePlan' => $this->feePlan,
            'to' => $this->to,
            'amount' => $this->amount,
            'feeRate' => $this->feeRate
        ];
        if (null !== $this->type) {
            $withdrawQueryData['type'] = $this->feePlan;
        }

        return $withdrawQueryData;
    }
}
