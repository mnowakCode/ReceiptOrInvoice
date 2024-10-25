<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Test\Unit\Observer;

use MNowakCode\ReceiptInvoiceButton\Observer\SaveChooseReceiptOrInvoiceObserver;
use MNowakCode\ReceiptInvoiceButton\Api\ReceiptOrInvoiceRepositoryInterface;
use MNowakCode\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterface;
use MNowakCode\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event;
use Magento\Sales\Model\Order;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SaveChooseReceiptOrInvoiceObserverTest extends TestCase
{
    /**
     * @var SaveChooseReceiptOrInvoiceObserver
     */
    private SaveChooseReceiptOrInvoiceObserver $observer;

    /**
     * @var MockObject
     */
    private MockObject $requestMock;

    /**
     * @var MockObject
     */
    private MockObject $receiptOrInvoiceFactoryMock;

    /**
     * @var MockObject
     */
    private MockObject $receiptOrInvoiceRepositoryMock;

    /**
     * @var MockObject
     */
    private MockObject $loggerMock;

    protected function setUp(): void
    {
        $this->requestMock = $this->createMock(Request::class);
        $this->receiptOrInvoiceFactoryMock = $this->createMock(ReceiptOrInvoiceInterfaceFactory::class);
        $this->receiptOrInvoiceRepositoryMock = $this->createMock(ReceiptOrInvoiceRepositoryInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->observer = new SaveChooseReceiptOrInvoiceObserver(
            $this->requestMock,
            $this->receiptOrInvoiceFactoryMock,
            $this->receiptOrInvoiceRepositoryMock,
            $this->loggerMock
        );
    }

    public function testExecuteSavesData()
    {
        $orderId = 123;
        $requestBody = [
            'paymentMethod' => [
                'extension_attributes' => [
                    'receiptOrInvoice' => 'invoice'
                ]
            ]
        ];
        $observerMock = $this->createMock(Observer::class);

        $eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->addMethods(['getOrder'])
            ->getMock();

        $orderMock = $this->createMock(Order::class);

        $this->requestMock->method('getBodyParams')->willReturn($requestBody);
        $observerMock->method('getEvent')->willReturn($eventMock);
        $eventMock->method('getOrder')->willReturn($orderMock);
        $orderMock->method('getId')->willReturn($orderId);

        $receiptOrInvoiceMock = $this->createMock(ReceiptOrInvoiceInterface::class);
        $this->receiptOrInvoiceFactoryMock->method('create')->willReturn($receiptOrInvoiceMock);

        $receiptOrInvoiceMock->expects($this->once())->method('setParentId')->with($orderId);
        $receiptOrInvoiceMock->expects($this->once())->method('setInvoice')->with(1);

        $this->receiptOrInvoiceRepositoryMock->expects($this->once())
            ->method('save')
            ->with($receiptOrInvoiceMock);

        $this->observer->execute($observerMock);
    }

    public function testExecuteHandlesCouldNotSaveException()
    {
        $orderId = 123;
        $requestBody = [
            'paymentMethod' => [
                'extension_attributes' => [
                    'receiptOrInvoice' => 'invoice'
                ]
            ]
        ];

        $this->requestMock->method('getBodyParams')->willReturn($requestBody);

        $observerMock = $this->createMock(Observer::class);

        $eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->addMethods(['getOrder'])
            ->getMock();

        $orderMock = $this->createMock(Order::class);
        $orderMock->method('getId')->willReturn($orderId);

        $receiptOrInvoiceMock = $this->createMock(ReceiptOrInvoiceInterface::class);
        $this->receiptOrInvoiceFactoryMock->method('create')->willReturn($receiptOrInvoiceMock);

        $eventMock->method('getOrder')->willReturn($orderMock);

        $observerMock->method('getEvent')->willReturn($eventMock);

        $this->receiptOrInvoiceRepositoryMock->method('save')
            ->willThrowException(new CouldNotSaveException(__('Save error')));

        $this->loggerMock->expects($this->once())
            ->method('warning')
            ->with('Save error');

        $this->observer->execute($observerMock);
    }

    public function testExecuteDoesNothingIfOrderIdIsNull()
    {
        $observerMock = $this->createMock(Observer::class);

        $eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->addMethods(['getOrder'])
            ->getMock();

        $orderMock = $this->createMock(Order::class);

        $orderMock->method('getId')->willReturn(null);
        $eventMock->method('getOrder')->willReturn($orderMock);
        $observerMock->method('getEvent')->willReturn($eventMock);

        $this->receiptOrInvoiceRepositoryMock->expects($this->never())->method('save');
        $this->observer->execute($observerMock);
    }
}
