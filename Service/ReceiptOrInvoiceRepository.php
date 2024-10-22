<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Service;

use MNowakCode\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;
use MNowakCode\ReceiptInvoiceButton\Api\ReceiptOrInvoiceRepositoryInterface;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice;
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
