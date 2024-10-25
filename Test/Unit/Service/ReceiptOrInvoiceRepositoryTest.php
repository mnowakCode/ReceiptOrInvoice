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
    private MockObject $collectionFactory;

    /**
     * @var MockObject
     */
    private MockObject $receiptOrInvoice;

    public function setUp(): void
    {
        $this->receiptOrInvoiceResource = $this->createMock(ReceiptOrInvoice::class);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->receiptOrInvoice = $this->createMock(ReceiptOrInvoiceModel::class);

        $this->object = new ReceiptOrInvoiceRepository($this->receiptOrInvoiceResource, $this->collectionFactory);
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

    public function testGetDocumentByOrderIdReturnsData()
    {
        $orderId = 123;
        $collection = $this->createMock(Collection::class);
        $this->collectionFactory->expects($this->once())->method('create')->willReturn($collection);

        $itemMock = $this->getMockBuilder(ReceiptOrInvoiceModel::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getEntityId', 'getParentId'])
            ->addMethods(['getIsInvoice'])
            ->getMock();

        $itemMock->method('getEntityId')->willReturn(1);
        $itemMock->method('getParentId')->willReturn($orderId);
        $itemMock->method('getIsInvoice')->willReturn('0');

        $collection->expects($this->once())
            ->method('addFieldToFilter')
            ->with('parent_id', $orderId)
            ->willReturnSelf();

        $collection->expects($this->once())
            ->method('getSize')
            ->willReturn(1);

        $collection->method('getIterator')
            ->willReturn(new ArrayIterator([$itemMock]));

        $documents = $this->object->getDocumentByOrderId($orderId);

        $expectedDocuments = [
            [
                'entity_id' => 1,
                'parent_id' => $orderId,
                'is_invoice' => '0',
            ]
        ];

        $this->assertEquals($expectedDocuments, $documents);
    }

    public function testGetDocumentByOrderIdThrowsException()
    {
        $orderId = 123;
        $collection = $this->createMock(Collection::class);
        $this->collectionFactory->expects($this->once())->method('create')->willReturn($collection);

        $collection->expects($this->once())
            ->method('addFieldToFilter')
            ->with('parent_id', $orderId)
            ->willReturnSelf();

        $collection->expects($this->once())
            ->method('getSize')
            ->willReturn(0);

        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage('No documents found for Order ID 123');

        $this->object->getDocumentByOrderId($orderId);
    }
}
