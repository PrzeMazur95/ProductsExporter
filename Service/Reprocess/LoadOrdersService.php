<?php

namespace YellowCard\ProductsExporter\Service\Reprocess;

use Magento\Sales\Api\OrderRepositoryInterface;

class LoadOrdersService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {
    }

    public function execute(array $raport)
    {
        $orderIds = $this->getOrderIdsFromRaport($raport);
        $orders = $this->loadOrders($orderIds);

        return $orders;
    }

    private function getOrderIdsFromRaport(array $raport): array
    {
        $orderIds = explode(',', $raport['orders']);

        return $orderIds;
    }

    private function loadOrders(array $orderIds): array
    {
        $orders = [];

        foreach ($orderIds as $orderId) {
            $orders[] = $this->orderRepository->get($orderId);
        }

        return $orders;
    }
}