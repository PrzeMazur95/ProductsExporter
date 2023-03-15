<?php

namespace YellowCard\ProductsExporter\Api;

use YellowCard\ProductsExporter\Api\Data\ExportInterface;

interface ExportRepositoryInterface
{
    /**
     * @param ExportInterface $export
     *
     * @return ExportInterface
     */
    public function save(ExportInterface $export): ExportInterface;
}