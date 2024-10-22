<?php

namespace Mano\ReceiptInvoiceButton\Api;

use Mano\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;

interface ReceiptOrInvoiceRepositoryInterface
{
    /**
     * Save receipt or invoice value
     *
     * @param ReceiptOrInvoiceInterface $receiptOrInvoice
     * @return ReceiptOrInvoiceInterface
     */
    public function save(ReceiptOrInvoiceInterface $receiptOrInvoice):ReceiptOrInvoiceInterface;
}
