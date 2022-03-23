<?php

namespace PlisioPhpSdk\Models\Withdraw;

use PlisioPhpSdk\Models\Fee\FeeParams;

class WithdrawResponse
{
    private string $type;
    private string $status;
    private string $psyscid;
    private string $currency;
    private string $sourceCurrency;
    private string $sourceRate;
    private string $fee;
    private string $walletHash;
    private ?array $sendmany = null;
    private FeeParams $params;
    private int $createdAtUtc;
    private string $amount;
    private ?string $txUrl = null;
    private ?array $txId = null;
    private string $id;

    public function __construct(
        string $type,
        string $status,
        string $psyscid,
        string $currency,
        string $sourceCurrency,
        string $sourceRate,
        string $fee,
        string $walletHash,
        ?array $sendmany,
        FeeParams $params,
        int $createdAtUtc,
        string $amount,
        ?string $txUrl,
        ?array $txId,
        string $id
    ) {
        $this->type = $type;
        $this->status = $status;
        $this->psyscid = $psyscid;
        $this->currency = $currency;
        $this->sourceCurrency = $sourceCurrency;
        $this->sourceRate = $sourceRate;
        $this->fee = $fee;
        $this->walletHash = $walletHash;
        $this->sendmany = $sendmany;
        $this->params = $params;
        $this->createdAtUtc = $createdAtUtc;
        $this->amount = $amount;
        $this->txUrl = $txUrl;
        $this->txId = $txId;
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPsyscid(): string
    {
        return $this->psyscid;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSourceCurrency(): string
    {
        return $this->sourceCurrency;
    }

    public function getSourceRate(): string
    {
        return $this->sourceRate;
    }

    public function getFee(): string
    {
        return $this->fee;
    }

    public function getWalletHash(): string
    {
        return $this->walletHash;
    }

    public function getSendmany(): ?array
    {
        return $this->sendmany;
    }

    public function getParams(): FeeParams
    {
        return $this->params;
    }

    public function getCreatedAtUtc(): int
    {
        return $this->createdAtUtc;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getTxUrl(): ?string
    {
        return $this->txUrl;
    }

    public function getTxId(): ?array
    {
        return $this->txId;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
