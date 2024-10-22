<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice;

use MNowakCode\ReceiptInvoiceButton\Model\ReceiptOrInvoice as Model;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'MNowakCode_receipt_or_invoice_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
