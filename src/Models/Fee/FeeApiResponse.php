<?php

namespace PlisioPhpSdk\Models\Fee;

class FeeApiResponse
{
    private string $status;
    private FeeResponse $feeResponse;

    public function __construct(string $status, FeeResponse $feeResponse)
    {
        $this->status = $status;
        $this->feeResponse = $feeResponse;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFeeResponse(): FeeResponse
    {
        return $this->feeResponse;
    }
}
