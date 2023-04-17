<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Service;

use Exception;
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
         private readonly ProductService $productService,
         private readonly LoggerInterface $logger,
         private readonly ManagerInterface $eventManager,
         private readonly CsvCreatorService $csvCreatorService
    ) {
    }

    /**
     * Generate csv file with ordered products
     */
    public function createExport(): array
    {
        $products = [];
        try {
            foreach ($this->productService->getProducts() as $product) {
                $products[] = $product;
            }
        } catch (Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
            $this->eventManager->dispatch('export_failed');
        }
        $this->csvCreatorService->createCsvFromGivenExportedProducts($products);

        $this->eventManager->dispatch('export_success');

        return $products;
    }
}