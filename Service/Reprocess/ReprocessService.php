<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service\Reprocess;

use YellowCard\ProductsExporter\Enum\ReprocessEnum;
use YellowCard\ProductsExporter\Service\CsvCreatorService;

class ReprocessService
{
    /**
     * @param LoadOrdersService $loadOrdersService
     * @param LoadProductsService $loadProductsService
     * @param CsvCreatorService   $csvCreatorService
     */
    public function __construct(
        private readonly LoadOrdersService $loadOrdersService,
        private readonly LoadProductsService $loadProductsService,
        private readonly CsvCreatorService $csvCreatorService
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
        $reprocess = [];

         $orders = $this->loadOrdersService->execute($specificRaport);
         $reprocess[ReprocessEnum::NAME->value] = ReprocessEnum::REPROCESS->value;
         $reprocess[ReprocessEnum::ID->value] = $specificRaport[ReprocessEnum::ID->value];
         $products = $this->loadProductsService->execute($orders);
         $this->csvCreatorService->createCsvFromGivenExportedProducts($products, $reprocess);
    }
}