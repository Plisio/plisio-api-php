<?php

namespace PlisioPhpSdk\Models\Withdraw;

class WithdrawApiResponse
{
    private string $status;
    private WithdrawResponse $withdrawResponse;

    public function __construct(string $status, WithdrawResponse $response)
    {
        $this->status = $status;
        $this->withdrawResponse = $response;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getWithdrawResponse(): WithdrawResponse
    {
        return $this->withdrawResponse;
    }
}
