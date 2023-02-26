<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Framework\Event\ManagerInterface;
use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;

class ExportService
{
    /**
     * @param ProductService   $productService
     * @param LoggerInterface  $logger
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        private ProductService $productService,
        private LoggerInterface $logger,
        private ManagerInterface $eventManager)
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
            $this->eventManager->dispatch('export_success');
        } catch (\Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
            $this->eventManager->dispatch('export_failed');
        }

    }
}