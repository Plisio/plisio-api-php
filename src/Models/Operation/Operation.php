<?php

namespace PlisioPhpSdk\Models\Operation;

class Operation
{
    private ?string $shopId;
    private string $type;
    private string $status;
    private string $pendingSum;
    private string $psysCid;
    private string $currency;
    private string $sourceCurrency;
    private string $sourceRate;
    private ?string $fee;
    private string $walletHash;
    private ?array $sendMany;
    private ?OperationParams $operationParams;
    private ?int $expireAtUtc;
    private int $createdAtUtc;
    private string $amount;
    private string $sum;
    private string $commission;
    private string $txUrl;
    private array $txId;
    private string $id;
    private string $actualSum;
    private ?string $actualCommission;
    private string $actualFee;
    private ?string $actualInvoiceSum;
    private array $transactionItems;
    private ?int $confirmations;
    private int $statusCode;
    private string $userId;

    public function __construct(
        ?string $shopId,
        string $type,
        string $status,
        string $pendingSum,
        string $psysCid,
        string $currency,
        string $sourceCurrency,
        string $sourceRate,
        ?string $fee,
        string $walletHash,
        ?array $sendMany,
        ?OperationParams $operationParams,
        ?int $expireAtUtc,
        int $createdAtUtc,
        string $amount,
        string $sum,
        string $commission,
        string $txUrl,
        array $txId,
        string $id,
        string $actualSum,
        ?string $actualCommission,
        string $actualFee,
        ?string $actualInvoiceSum,
        array $transactionItems,
        ?int $confirmations,
        int $statusCode,
        string $userId
    ) {
        $this->shopId = $shopId;
        $this->type = $type;
        $this->status = $status;
        $this->pendingSum = $pendingSum;
        $this->psysCid = $psysCid;
        $this->currency = $currency;
        $this->sourceCurrency = $sourceCurrency;
        $this->sourceRate = $sourceRate;
        $this->fee = $fee;
        $this->walletHash = $walletHash;
        $this->sendMany = $sendMany;
        $this->operationParams = $operationParams;
        $this->expireAtUtc = $expireAtUtc;
        $this->createdAtUtc = $createdAtUtc;
        $this->amount = $amount;
        $this->sum = $sum;
        $this->commission = $commission;
        $this->txUrl = $txUrl;
        $this->txId = $txId;
        $this->id = $id;
        $this->actualSum = $actualSum;
        $this->actualCommission = $actualCommission;
        $this->actualFee = $actualFee;
        $this->actualInvoiceSum = $actualInvoiceSum;
        $this->transactionItems = $transactionItems;
        $this->confirmations = $confirmations;
        $this->statusCode = $statusCode;
        $this->userId = $userId;
    }

    public function getShopId(): ?string
    {
        return $this->shopId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPendingSum(): string
    {
        return $this->pendingSum;
    }

    public function getPsysCid(): string
    {
        return $this->psysCid;
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

    public function getFee(): ?string
    {
        return $this->fee;
    }

    public function getWalletHash(): string
    {
        return $this->walletHash;
    }

    public function getSendMany(): ?array
    {
        return $this->sendMany;
    }

    public function getOperationParams(): ?OperationParams
    {
        return $this->operationParams;
    }

    public function getExpireAtUtc(): ?int
    {
        return $this->expireAtUtc;
    }

    public function getCreatedAtUtc(): int
    {
        return $this->createdAtUtc;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    public function getCommission(): string
    {
        return $this->commission;
    }

    public function getTxUrl(): string
    {
        return $this->txUrl;
    }

    public function getTxId(): array
    {
        return $this->txId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getActualSum(): string
    {
        return $this->actualSum;
    }

    public function getActualCommission(): ?string
    {
        return $this->actualCommission;
    }

    public function getActualFee(): string
    {
        return $this->actualFee;
    }

    public function getActualInvoiceSum(): ?string
    {
        return $this->actualInvoiceSum;
    }

    public function getTransactionItems(): array
    {
        return $this->transactionItems;
    }

    public function getConfirmations(): ?int
    {
        return $this->confirmations;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
