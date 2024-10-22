<?php

namespace MNowakCode\ReceiptInvoiceButton\Api\Data;

interface ReceiptOrInvoiceInterface
{
    public const ENTITY_ID = 'entity_id';
    public const PARENT_ID = 'parent_id';
    public const IS_INVOICE = 'is_invoice';

    /**
     * Getter for entity id
     *
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Setter for entity id
     *
     * @param int|null $entityId
     * @return void
     */
    public function setEntityId(?int $entityId): void;

    /**
     * Getter for parent id
     *
     * @return int|null
     */
    public function getParentId(): ?int;

    /**
     * Setter for parent id
     *
     * @param int|null $orderId
     * @return void
     */
    public function setParentId(?int $orderId): void;

    /**
     * Getter for invoice value
     *
     * @return int
     */
    public function getInvoice(): int;

    /**
     * Setter for invoice
     *
     * @param int $invoice
     * @return void
     */
    public function setInvoice(int $invoice): void;
}
