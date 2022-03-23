<?php

namespace PlisioPhpSdk\Models\Commission;

class CommissionApiResponse
{
    private string $status;
    private CommissionResponse $commissionResponse;

    public function __construct(string $status, CommissionResponse $commissionResponse)
    {
        $this->status = $status;
        $this->commissionResponse = $commissionResponse;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCommissionResponse(): CommissionResponse
    {
        return $this->commissionResponse;
    }
}
