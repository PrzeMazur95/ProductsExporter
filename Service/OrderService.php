<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class OrderService
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param StatusService     $statusService
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private StatusService $statusService,
        private OrderRepositoryInterface $orderRepository,
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
     * Loads all orders with specific status, found by ids provided from method above
     *
     * @return array
     */
    public function getOrders(): array
    {
        $orders = [];
        foreach ($this->getOrderIds() as $orderId) {
            $orders[] = $this->orderRepository->get($orderId->getIncrementId());
        }

        return $orders;
    }
}