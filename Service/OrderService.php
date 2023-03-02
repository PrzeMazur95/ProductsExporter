<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;
use YellowCard\ProductsExporter\Model\ExportedOrdersFactory;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;

class OrderService
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param StatusService $statusService
     * @param OrderRepositoryInterface $orderRepository
     * @param ExportedOrdersFactory $exportedOrdersFactory
     * @param ExportedOrdersResource $exportedOrdersResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private StatusService $statusService,
        private OrderRepositoryInterface $orderRepository,
        private ExportedOrdersFactory $exportedOrdersFactory,
        private ExportedOrdersResource $exportedOrdersResource,
        private LoggerInterface $logger
    ) {
    }

    /**
     * Returns collection of orders IDS with specific status provided in config by user
     *
     * @return Collection
     */
    public function getOrderIds(): Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', $this->statusService->getStatus());
        $collection->addAttributeToSelect(OrderInterface::INCREMENT_ID);

        return $collection;
    }

    /**
     * Returns all orders with specific status, found by ids provided from method above
     *
     * @return array
     */
    public function getOrders(): array
    {
        $orders = [];
        $orderIds = [];
        foreach ($this->getOrderIds() as $orderId) {
            $orders[] = $this->orderRepository->get($orderId->getIncrementId());
            $orderIds[] = $orderId->getIncrementId();
        }
        $this->saveOrderIds($orderIds);

        return $orders;
    }

    /**
     * Saves string of orders from which the export was generated
     *
     * @param array $orderIds
     *
     * @return void
     */
    private function saveOrderIds(array $orderIds): void
    {
        $stringOfOrderNumbers = $this->convertOrderArrayToString($orderIds);

        $exportedOrders = $this->exportedOrdersFactory->create();
        $exportedOrders->setOrders($stringOfOrderNumbers);
        $exportedOrders->setRaportId(1);

        try{
            $this->exportedOrdersResource->save($exportedOrders);
        } catch (\Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
        }
    }

    /**
     * Converts array of given orders to a string, to store it in this form in the database
     *
     * @param array $orderIds
     *
     * @return string
     */
    private function convertOrderArrayToString(array $orderIds): string
    {
        return implode(",", $orderIds);
    }
}