<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use YellowCard\ProductsExporter\Api\Data\ExportInterface;
use YellowCard\ProductsExporter\Api\ExportRepositoryInterface;
use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

class ExportRepository implements ExportRepositoryInterface
{
    /**
     * @param ExportResource  $exportResource
     */
    public function __construct(
        private ExportResource $exportResource
    ) {
    }

    /**
     * Save into db a raport that has been done, and its date and status
     *
     * @param ExportInterface $export
     *
     * @return ExportInterface
     */
    public function save(ExportInterface $export): ExportInterface
    {
        $this->exportResource->save($export);

        return $export;
    }
}