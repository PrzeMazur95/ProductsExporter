<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service\Reprocess;

class ReprocessService
{
    /**
     * @param LoadOrdersService $loadOrdersService
     * @param LoadProductsService $loadProductsService
     */
    public function __construct(
        private readonly LoadOrdersService $loadOrdersService,
        private readonly LoadProductsService $loadProductsService
    ) {
    }

    /**
     * Reprocess export of given order numbers from specific raport
     *
     * @param array $specificRaport
     *
     * @return void
     */
    public function reprocess(array $specificRaport)
    {
        $orders = $this->loadOrdersService->execute($specificRaport);
        $products = $this->loadProductsService->execute($orders);
    }
}