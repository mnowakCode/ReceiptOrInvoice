<?php

declare(strict_types=1);

namespace Mano\ReceiptInvoiceButton\Model;

use Mano\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;
use Mano\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class ReceiptOrInvoice extends AbstractModel implements ReceiptOrInvoiceInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'mano_receipt_or_invoice_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID) === null
            ? null
            : (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId): void
    {
        $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): ?int
    {
        return $this->getData(self::PARENT_ID) === null
            ? null
            : (int)$this->getData(self::PARENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setParentId(?int $orderId): void
    {
        $this->setData(self::PARENT_ID, $orderId);
    }

    /**
     * @inheritDoc
     */
    public function getInvoice(): int
    {
        return $this->getData(self::IS_INVOICE);
    }

    /**
     * @inheritDoc
     */
    public function setInvoice(int $invoice): void
    {
        $this->setData(self::IS_INVOICE, $invoice);
    }
}
