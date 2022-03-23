<?php

namespace PlisioPhpSdk\Models\Invoice;

class InvoiceExtendedResponse
{
    private ?string $amount;
    private ?string $pendingAmount;
    private ?string $walletHash;
    private ?string $psyscid;
    private ?string $currency;
    private ?string $sourceCurrency;
    private ?string $sourceRate;
    private ?string $expectedConfirmations;
    private ?string $qrCode;
    private ?string $verifyHash;
    private ?string $invoiceCommission;
    private ?string $invoiceSum;
    private ?string $invoiceTotalSum;
    private string $txnId;
    private string $invoiceUrl;

    public function __construct(
        ?string $amount,
        ?string $pendingAmount,
        ?string $walletHash,
        ?string $psyscid,
        ?string $currency,
        ?string $sourceCurrency,
        ?string $sourceRate,
        ?string $expectedConfirmations,
        ?string $qrCode,
        ?string $verifyHash,
        ?string $invoiceCommission,
        ?string $invoiceSum,
        ?string $invoiceTotalSum,
        string $txnId,
        string $invoiceUrl
    ) {
        $this->amount = $amount;
        $this->pendingAmount = $pendingAmount;
        $this->walletHash = $walletHash;
        $this->psyscid = $psyscid;
        $this->currency = $currency;
        $this->sourceCurrency = $sourceCurrency;
        $this->sourceRate = $sourceRate;
        $this->expectedConfirmations = $expectedConfirmations;
        $this->qrCode = $qrCode;
        $this->verifyHash = $verifyHash;
        $this->invoiceCommission = $invoiceCommission;
        $this->invoiceSum = $invoiceSum;
        $this->invoiceTotalSum = $invoiceTotalSum;
        $this->txnId = $txnId;
        $this->invoiceUrl = $invoiceUrl;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getPendingAmount(): ?string
    {
        return $this->pendingAmount;
    }

    public function getWalletHash(): ?string
    {
        return $this->walletHash;
    }

    public function getPsyscid(): ?string
    {
        return $this->psyscid;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getSourceCurrency(): ?string
    {
        return $this->sourceCurrency;
    }

    public function getSourceRate(): ?string
    {
        return $this->sourceRate;
    }

    public function getExpectedConfirmations(): ?string
    {
        return $this->expectedConfirmations;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function getVerifyHash(): ?string
    {
        return $this->verifyHash;
    }

    public function getInvoiceCommission(): ?string
    {
        return $this->invoiceCommission;
    }

    public function getInvoiceSum(): ?string
    {
        return $this->invoiceSum;
    }

    public function getInvoiceTotalSum(): ?string
    {
        return $this->invoiceTotalSum;
    }

    public function getTxnId(): string
    {
        return $this->txnId;
    }

    public function getInvoiceUrl(): string
    {
        return $this->invoiceUrl;
    }
}
