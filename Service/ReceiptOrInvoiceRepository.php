<?php

declare(strict_types=1);

namespace Mano\ReceiptInvoiceButton\Service;

use Mano\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;
use Mano\ReceiptInvoiceButton\Api\ReceiptOrInvoiceRepositoryInterface;
use Mano\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;

class ReceiptOrInvoiceRepository implements ReceiptOrInvoiceRepositoryInterface
{
    /**
     * @var ReceiptOrInvoice
     */
    private ReceiptOrInvoice $receiptOrInvoiceResource;
    /**
     * @param ReceiptOrInvoice $receiptOrInvoiceResource
     */
    public function __construct(ReceiptOrInvoice $receiptOrInvoiceResource)
    {
        $this->receiptOrInvoiceResource = $receiptOrInvoiceResource;
    }

    /**
     * @param ReceiptOrInvoiceInterface $receiptOrInvoice
     * @return ReceiptOrInvoiceInterface
     * @throws CouldNotSaveException
     */
    public function save(ReceiptOrInvoiceInterface $receiptOrInvoice): ReceiptOrInvoiceInterface
    {
        {
            try {
                $this->receiptOrInvoiceResource->save($receiptOrInvoice);
            } catch (Exception $e) {
                throw new CouldNotSaveException(__('Could not save the data about invoice.'), $e);
            }
            return $receiptOrInvoice;
        }
    }
}
