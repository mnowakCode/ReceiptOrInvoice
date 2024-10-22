<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReceiptOrInvoice extends AbstractDb
{
    /**
     * @var string
     */
    protected string $_eventPrefix = 'MNowakCode_receipt_or_invoice_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('sales_order_document_type', 'entity_id');
    }
}
