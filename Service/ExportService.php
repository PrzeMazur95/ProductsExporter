<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Magento\Framework\Event\ManagerInterface;
use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;

class ExportService
{
    /**
     * @param ProductService    $productService
     * @param LoggerInterface   $logger
     * @param ManagerInterface  $eventManager
     * @param CsvCreatorService $csvCreatorService
     */
    public function __construct(
        private ProductService $productService,
        private LoggerInterface $logger,
        private ManagerInterface $eventManager,
        private CsvCreatorService $csvCreatorService
    ) {
    }

    /**
     * FOr now returns an array, each row contains products ordered in specific order. Will create a file which will be downloadable
     */
    public function createExport()
    {
        $products = [];
        try {
            foreach ($this->productService->getProducts() as $product) {
                $products[] = $product;
            }
        } catch (\Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
            $this->eventManager->dispatch('export_failed');
        }
        $this->csvCreatorService->createCsvFromGivenExportedProducts($products);

        $this->eventManager->dispatch('export_success');

        return $products;
    }
}