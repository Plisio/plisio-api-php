<?php

namespace PlisioPhpSdk\Http;

use PlisioPhpSdk\Models\Balance\BalanceApiResponse;
use PlisioPhpSdk\Models\Commission\CommissionQuery;
use PlisioPhpSdk\Models\Commission\CommissionApiResponse;
use PlisioPhpSdk\Models\Cryptocurrency\CryptocurrencyApiResponse;
use PlisioPhpSdk\Models\Fee\FeeApiResponse;
use PlisioPhpSdk\Models\Fee\FeePlanApiResponse;
use PlisioPhpSdk\Models\Fee\FeeQuery;
use PlisioPhpSdk\Models\Invoice\InvoiceQuery;
use PlisioPhpSdk\Models\Invoice\InvoiceWhiteLabelResponse;
use PlisioPhpSdk\Models\Operation\OperationApiResponse;
use PlisioPhpSdk\Models\Withdraw\WithdrawApiResponse;
use PlisioPhpSdk\Models\Withdraw\WithdrawQuery;
use Throwable;

interface InteractionInterface
{
    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return BalanceApiResponse on success
     */
    public function getBalance(string $currency): ?BalanceApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return OperationApiResponse on success
     */
    public function getOperationById(string $id): ?OperationApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return CommissionApiResponse on success
     */
    public function getCommission(CommissionQuery $query): ?CommissionApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return CryptocurrencyApiResponse on success
     */
    public function getCurrencyInfoByFiat(string $fiat): ?CryptocurrencyApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return FeePlanApiResponse on success
     */
    public function getFeePlanByPsyscid(string $psyscid): ?FeePlanApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return WithdrawApiResponse on success
     */
    public function withdraw(WithdrawQuery $withdrawQuery): ?WithdrawApiResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return null on errors (If silent mode turn on)
     * @return InvoiceWhiteLabelResponse on success
     */
    public function createInvoice(InvoiceQuery $invoiceQuery): ?InvoiceWhiteLabelResponse;

    /**
     * @throws Throwable on errors (If silent mode turn off)
     * @return FeeApiResponse on success
     * @return null on errors (If silent mode turn on)
     */
    public function getFee(FeeQuery $feeQuery): ?FeeApiResponse;
}
