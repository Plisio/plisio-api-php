<?php

namespace PlisioPhpSdk\Common\Config;

use Webmozart\Assert\Assert;

class Config
{
    private string $apiKey;
    private string $baseUri;
    private string $currentEnv;
    private bool $silent;

    private ?Auth $auth = null;

    public function __construct(string $apiKey, string $baseUri, string $currentEnv, bool $silent)
    {
        Assert::notEmpty($apiKey);
        Assert::notEmpty($baseUri);
        Assert::notEmpty($currentEnv);

        $this->apiKey = $apiKey;
        $this->baseUri = $baseUri;
        $this->currentEnv = $currentEnv;
        $this->silent = $silent;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setAuth(Auth $auth): self
    {
        $this->auth = $auth;

        return $this;
    }

    public function getAuth(): ?Auth
    {
        return $this->auth;
    }

    public function getCurrentEnv(): string
    {
        return $this->currentEnv;
    }

    public function isSilent(): bool
    {
        return $this->silent;
    }
}
