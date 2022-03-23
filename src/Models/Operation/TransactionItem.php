<?php

namespace PlisioPhpSdk\Models\Operation;

class TransactionItem
{
    private string $id;
    private int $block;
    private int $confirmations;
    private string $value;
    private bool $processed;
    private ?int $failRetry;
    private ?string $feeRate;
    private ?string $feeRateUnit;
    private string $url;
    private array $walletHash;

    public function __construct(
        string $id,
        int $block,
        int $confirmations,
        string $value,
        bool $processed,
        ?int $failRetry,
        ?string $feeRate,
        ?string $feeRateUnit,
        string $url,
        array $walletHash
    ) {
        $this->id = $id;
        $this->block = $block;
        $this->confirmations = $confirmations;
        $this->value = $value;
        $this->processed = $processed;
        $this->failRetry = $failRetry;
        $this->feeRate = $feeRate;
        $this->feeRateUnit = $feeRateUnit;
        $this->url = $url;
        $this->walletHash = $walletHash;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['txid'],
            $data['block'],
            $data['confirmations'],
            $data['value'],
            $data['processed'],
            $data['fail_retry'],
            $data['fee_rate'],
            $data['fee_rate_unit'],
            $data['url'],
            $data['wallet_hash']
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBlock(): int
    {
        return $this->block;
    }

    public function getConfirmations(): int
    {
        return $this->confirmations;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function getFailRetry(): ?int
    {
        return $this->failRetry;
    }

    public function getFeeRate(): ?string
    {
        return $this->feeRate;
    }

    public function getFeeRateUnit(): ?string
    {
        return $this->feeRateUnit;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getWalletHash(): array
    {
        return $this->walletHash;
    }
}
