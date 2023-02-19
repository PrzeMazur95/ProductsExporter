<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Psr\Log\LoggerInterface;

class ExportService
{
    /**
     * @param ProductService  $productService
     * @param LoggerInterface $logger
     */
    public function __construct(private ProductService $productService, private LoggerInterface $logger)
    {
    }

    /**
     * Shows on the screen purchases products from provided orders. Sku, quantity and order Id
     *
     * @return void
     */
    public function createExport(): void
    {
        try {
            foreach ($this->productService->getProducts() as $product) {
                foreach ($product as $item) {
                    echo $item->getSku()
                        . " " . number_format((float)$item->getQtyOrdered(), 2)
                        . " " . $item->getOrderId() . '</br>';
                }
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

    }
}