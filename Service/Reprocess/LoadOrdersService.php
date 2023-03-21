<?php

namespace YellowCard\ProductsExporter\Service\Reprocess;

use Magento\Sales\Api\OrderRepositoryInterface;

class LoadOrdersService
{
     /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {
    }

     /**
     * Return specified orders from database filtered by specified numbers
     *
     * @param array $raport
     *
     * @return array
     */
    public function execute(array $raport)
    {
        $orderIds = $this->getOrderIdsFromRaport($raport);
        $orders = $this->loadOrders($orderIds);

        return $orders;
    }

    /**
     * Return array of strings with order numbers from string taken from provided raport
     *
     * @param array $raport
     *
     * @return array
     */
    private function getOrderIdsFromRaport(array $raport): array
    {
        $orderIds = explode(',', $raport['orders']);

        return $orderIds;
    }

     /**
     * Load all orders from provided array with Ids
     *
     * @param array $orderIds
     *
     * @return array
     */
    private function loadOrders(array $orderIds): array
    {
        $orders = [];

        foreach ($orderIds as $orderId) {
            $orders[] = $this->orderRepository->get($orderId);
        }

        return $orders;
    }
}