<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use MNowakCode\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;
use MNowakCode\ReceiptInvoiceButton\Api\ReceiptOrInvoiceRepositoryInterface;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice\CollectionFactory;

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
     * @inheritdoc
     *
     * @throws CouldNotSaveException
     */
    public function save(ReceiptOrInvoiceInterface $receiptOrInvoice): ReceiptOrInvoiceInterface
    {
        try {
            $this->receiptOrInvoiceResource->save($receiptOrInvoice);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the data about invoice.'), $e);
        }

        return $receiptOrInvoice;
    }
}
