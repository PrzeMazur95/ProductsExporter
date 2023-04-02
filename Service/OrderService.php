<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
use YellowCard\ProductsExporter\Model\ExportedOrdersFactory;

class OrderService
{
    /**
     * @param CollectionFactory $collectionFactory
     * @param StatusService $statusService
     * @param OrderRepositoryInterface $orderRepository
     * @param ExportedOrdersFactory $exportedOrdersFactory
     * @param ExportedOrdersRepositoryInterface $exportedOrdersRepository
     * @param QuantityService $quantityService
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private StatusService $statusService,
        private OrderRepositoryInterface $orderRepository,
        private ExportedOrdersFactory $exportedOrdersFactory,
        private ExportedOrdersRepositoryInterface $exportedOrdersRepository,
        private QuantityService $quantityService
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
        $collection->setOrder('created_at', 'asc');
        $collection->setPageSize($this->quantityService->getOrdersQuantityToExport());
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

        $this->exportedOrdersRepository->save($exportedOrders);
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