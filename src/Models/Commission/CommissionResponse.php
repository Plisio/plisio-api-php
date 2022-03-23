<?php

namespace PlisioPhpSdk\Models\Commission;

use PlisioPhpSdk\Models\Fee\FeePlanCustomItem;

class CommissionResponse
{
    private string $commission;
    private string $fee;
    private string $plan;
    private ?string $useWallet;
    private ?string $useWalletBalance;
    private array $plans;
    private FeePlanCustomItem $custom;

    public function __construct(
        string $commission,
        string $fee,
        string $plan,
        ?string $useWallet,
        ?string $useWalletBalance,
        array $plans,
        FeePlanCustomItem $custom
    ) {
        $this->commission = $commission;
        $this->fee = $fee;
        $this->plan = $plan;
        $this->useWallet = $useWallet;
        $this->useWalletBalance = $useWalletBalance;
        $this->plans = $plans;
        $this->custom = $custom;
    }

    public function getCommission(): string
    {
        return $this->commission;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function getUseWallet(): ?string
    {
        return $this->useWallet;
    }

    public function getUseWalletBalance(): ?string
    {
        return $this->useWalletBalance;
    }

    public function getPlans(): array
    {
        return $this->plans;
    }

    public function getCustom(): FeePlanCustomItem
    {
        return $this->custom;
    }
}
