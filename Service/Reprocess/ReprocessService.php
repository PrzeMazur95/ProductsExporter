<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service\Reprocess;

class ReprocessService
{
    /**
     * @param LoadOrdersService $loadOrdersService
     */
    public function __construct(
        private readonly LoadOrdersService $loadOrdersService
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
    }
}