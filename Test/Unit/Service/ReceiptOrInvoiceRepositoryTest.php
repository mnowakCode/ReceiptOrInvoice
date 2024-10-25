<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Tests\Unit\Service;

use ArrayIterator;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use MNowakCode\ReceiptInvoiceButton\Model\ReceiptOrInvoice as ReceiptOrInvoiceModel;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice\Collection;
use MNowakCode\ReceiptInvoiceButton\Model\ResourceModel\ReceiptOrInvoice\CollectionFactory;
use MNowakCode\ReceiptInvoiceButton\Service\ReceiptOrInvoiceRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ReceiptOrInvoiceRepositoryTest extends TestCase
{
    /**
     * @var ReceiptOrInvoiceRepository
     */
    private ReceiptOrInvoiceRepository $object;

    /**
     * @var MockObject
     */
    private MockObject $receiptOrInvoiceResource;

    /**
     * @var MockObject
     */
    private MockObject $receiptOrInvoice;

    public function setUp(): void
    {
        $this->receiptOrInvoiceResource = $this->createMock(ReceiptOrInvoice::class);
        $this->receiptOrInvoice = $this->createMock(ReceiptOrInvoiceModel::class);

        $this->object = new ReceiptOrInvoiceRepository($this->receiptOrInvoiceResource);
    }

    public function testSaveWorking()
    {
        $this->receiptOrInvoiceResource->expects($this->once())->method('save')
            ->with($this->receiptOrInvoice);

        $this->object->save($this->receiptOrInvoice);
    }

    public function testSaveThrowException()
    {
        $exception = new Exception('Database error');

        $this->receiptOrInvoiceResource->expects($this->once())
            ->method('save')
            ->with($this->receiptOrInvoice)
            ->willThrowException($exception);

        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage('Could not save the data about invoice.');

        $this->object->save($this->receiptOrInvoice);
        $this->receiptOrInvoiceResource->expects($this->once())->method('save')
            ->willThrowException(new CouldNotSaveException(__('Could not save the data about invoice.')));

        $this->object->save($this->receiptOrInvoice);
    }
}
