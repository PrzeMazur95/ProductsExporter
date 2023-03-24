<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use YellowCard\ProductsExporter\Service\ExportService;

class Export implements ArgumentInterface
{
    /**
     * @param ExportService $exportService
     */
    public function __construct(
      private readonly ExportService $exportService
    ){
    }

    /**
     * Get all purchased products in rows, in one row are all ordered products in specific order
     *
     * @return array
     */
    public function createExport(): array
    {
        $products = $this->exportService->createExport();
        return $products;
    }
}