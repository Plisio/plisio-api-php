<?php

namespace PlisioPhpSdk\Models\Invoice;

class InvoiceWhiteLabelResponse
{
    private string $status;
    private InvoiceExtendedResponse $response;

    public function __construct(string $status, InvoiceExtendedResponse $response)
    {
        $this->status = $status;
        $this->response = $response;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getResponse(): InvoiceExtendedResponse
    {
        return $this->response;
    }
}
