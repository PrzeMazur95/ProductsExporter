<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use YellowCard\ProductsExporter\Model\ExportedOrdersFactory;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;

class OrderService
{
    /**
     * @param CollectionFactory        $collectionFactory
     * @param StatusService            $statusService
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private StatusService $statusService,
        private OrderRepositoryInterface $orderRepository,
        private ExportedOrdersFactory $exportedOrdersFactory,
        private ExportedOrdersResource $exportedOrdersResource
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

    private function saveOrderIds(array $orderIds): void
    {
        $stringOfOrderNumbers = $this->convertOrderArrayToString($orderIds);

        $exportedOrders = $this->exportedOrdersFactory->create();
        $exportedOrders->setOrders($stringOfOrderNumbers);
        $exportedOrders->setRaportId(1);

        $this->exportedOrdersResource->save($exportedOrders);        
    }

    private function convertOrderArrayToString(array $orderIds): string
    {
        return implode(",", $orderIds);
    }
}