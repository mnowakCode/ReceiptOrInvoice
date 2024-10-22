<?php

declare(strict_types=1);

namespace MNowakCode\ReceiptInvoiceButton\Observer;

use MNowakCode\ReceiptInvoiceButton\Api\ReceiptOrInvoiceRepositoryInterface;
use MNowakCode\ReceiptInvoiceButton\Api\Data\ReceiptOrInvoiceInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class SaveChooseReceiptOrInvoiceObserver implements ObserverInterface
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var ReceiptOrInvoiceInterfaceFactory
     */
    private ReceiptOrInvoiceInterfaceFactory $receiptOrInvoiceInterfaceFactory;

    /**
     * @var ReceiptOrInvoiceRepositoryInterface
     */
    private ReceiptOrInvoiceRepositoryInterface $receiptOrInvoiceRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param Request $request
     * @param ReceiptOrInvoiceInterfaceFactory $receiptOrInvoiceInterfaceFactory
     * @param ReceiptOrInvoiceRepositoryInterface $receiptOrInvoiceRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Request $request,
        ReceiptOrInvoiceInterfaceFactory $receiptOrInvoiceInterfaceFactory,
        ReceiptOrInvoiceRepositoryInterface $receiptOrInvoiceRepository,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->receiptOrInvoiceInterfaceFactory = $receiptOrInvoiceInterfaceFactory;
        $this->receiptOrInvoiceRepository = $receiptOrInvoiceRepository;
        $this->logger = $logger;
    }

    /**
     * Observer for sales_order_save_after.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $value = $this->getValueFromRequest();
            $order = $observer->getEvent()->getOrder();

            if (!$order->getId()) {
                return;
            }

            $isInvoice = $value == 'invoice' ? 1 : 0;
            $orderId = $order->getId();
            $receiptOrInvoice = $this->receiptOrInvoiceInterfaceFactory->create();
            $receiptOrInvoice->setParentId((int)$orderId);
            $receiptOrInvoice->setInvoice($isInvoice);

            $this->receiptOrInvoiceRepository->save($receiptOrInvoice);
        } catch (CouldNotSaveException $exception) {
            $this->logger->warning($exception->getMessage());
        }
    }

    /**
     * @return false|string
     */
    private function getValueFromRequest()
    {
        $requestBody = $this->request->getBodyParams();

        return $requestBody['paymentMethod']['extension_attributes']['receiptOrInvoice'] ?? false;
    }
}
