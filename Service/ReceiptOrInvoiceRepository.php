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
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param ReceiptOrInvoice $receiptOrInvoiceResource
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(ReceiptOrInvoice $receiptOrInvoiceResource, CollectionFactory $collectionFactory)
    {
        $this->receiptOrInvoiceResource = $receiptOrInvoiceResource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
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

    /**
     * @inheritdoc
     * @throws NoSuchEntityException
     */
    public function getDocumentByOrderId($orderId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('parent_id', $orderId);

        if ($collection->getSize() == 0) {
            throw new NoSuchEntityException(__('No documents found for Order ID %1', $orderId));
        }

        $documents = [];
        foreach ($collection as $item) {
            $documents[] = [
                'entity_id' => $item->getEntityId(),
                'parent_id' => $item->getParentId(),
                'is_invoice' => $item->getIsInvoice()
            ];
        }

        return $documents;
    }
}
