<?php

namespace PlisioPhpSdk\Models\Operation;

class OperationApiResponse
{
    private string $status;
    private Operation $operation;

    public function __construct(string $status, Operation $operation)
    {
        $this->status = $status;
        $this->operation = $operation;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOperation(): Operation
    {
        return $this->operation;
    }
}
