<?php

namespace PlisioPhpSdk\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use PlisioPhpSdk\Common\Config\Config;
use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Common\Enum\FiatCurrencies;
use PlisioPhpSdk\Models\Balance\BalanceApiResponse;
use PlisioPhpSdk\Models\Commission\CommissionApiResponse;
use PlisioPhpSdk\Models\Commission\CommissionQuery;
use PlisioPhpSdk\Models\Cryptocurrency\CryptocurrencyApiResponse;
use PlisioPhpSdk\Models\Fee\FeeApiResponse;
use PlisioPhpSdk\Models\Fee\FeePlanApiResponse;
use PlisioPhpSdk\Models\Fee\FeeQuery;
use PlisioPhpSdk\Models\Invoice\InvoiceQuery;
use PlisioPhpSdk\Models\Invoice\InvoiceWhiteLabelResponse;
use PlisioPhpSdk\Models\Operation\OperationApiResponse;
use PlisioPhpSdk\Models\Withdraw\WithdrawApiResponse;
use PlisioPhpSdk\Models\Withdraw\WithdrawQuery;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;
use Webmozart\Assert\Assert;

class Interaction implements InteractionInterface
{
    private ClientInterface $client;
    private LoggerInterface $logger;
    private SerializerInterface $serializer;
    private Config $config;

    public function __construct(
        ClientInterface $client,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        Config $config
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getBalance(string $currency): ?BalanceApiResponse
    {
        Assert::notEmpty($currency);
        Assert::inArray($currency, Currencies::asArray());

        $response = $this->execute("balances/$currency");
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(BalanceApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function getOperationById(string $id): ?OperationApiResponse
    {
        Assert::notEmpty($id);

        $response = $this->execute("operations/$id");
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(OperationApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function getCommission(CommissionQuery $query): ?CommissionApiResponse
    {
        $response = $this->execute(
            "operations/commission/{$query->getPsyscid()}",
            count($query->toArray()) > 0 ? $query->toArray() : []
        );
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(CommissionApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrencyInfoByFiat(string $fiat): ?CryptocurrencyApiResponse
    {
        Assert::notEmpty($fiat);
        Assert::inArray($fiat, FiatCurrencies::asArray());

        $response = $this->execute("currencies/$fiat");
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(CryptocurrencyApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function getFeePlanByPsyscid(string $psyscid): ?FeePlanApiResponse
    {
        Assert::notEmpty($psyscid);
        Assert::inArray($psyscid, Currencies::asArray());

        $response = $this->execute("operations/fee-plan/$psyscid");
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(FeePlanApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function withdraw(WithdrawQuery $withdrawQuery): ?WithdrawApiResponse
    {
        $response = $this->execute('operations/withdraw', $withdrawQuery->toArray());
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(WithdrawApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function createInvoice(InvoiceQuery $invoiceQuery): ?InvoiceWhiteLabelResponse
    {
        $response = $this->execute('invoices/new', $invoiceQuery->toArray());
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(InvoiceWhiteLabelResponse::class, $response->getBody()->getContents());
    }

    /**
     * {@inheritDoc}
     */
    public function getFee(FeeQuery $feeQuery): ?FeeApiResponse
    {
        $response = $this->execute("operations/fee/{$feeQuery->getPsyscid()}", $feeQuery->toArray());
        if (null === $response) {
            return null;
        }

        return $this->responseToModel(FeeApiResponse::class, $response->getBody()->getContents());
    }

    /**
     * @throws Throwable on error (if silent mode turn off)
     * @return null on errors (if silent mode turn on)
     * @return object on success, response model
     */
    private function responseToModel(string $model, string $content)
    {
        try {
            return $this->serializer->deserialize($content, $model, 'json');
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            if (!$this->config->isSilent()) {
                throw $e;
            }
        }

        return null;
    }

    /**
     * @throws GuzzleException on error (if silent mode turn off)
     * @return null on error (if silent mode turn on)
     * @return ResponseInterface on success
     */
    private function execute(string $url, ?array $options = null): ?ResponseInterface
    {
        try {
            $baseOptions = ['api_key' => $this->config->getApiKey()];
            if (null !== $options) {
                $baseOptions = array_merge($baseOptions, $options);
            }
            $requestOptions = ['query' => $baseOptions];
            if (null !== $auth = $this->config->getAuth()) {
                $requestOptions['auth'] = [$auth->getUser(), $auth->getPassword()];
            }

            return $this->client->request('GET', $url, $requestOptions);
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            if (!$this->config->isSilent()) {
                throw $e;
            }
        }

        return null;
    }
}
