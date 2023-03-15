<?php

namespace YellowCard\ProductsExporter\Api;

use YellowCard\ProductsExporter\Api\Data\ExportedOrdersInterface;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders\Collection;

interface ExportedOrdersRepositoryInterface
{
    /**
     * @param ExportedOrdersInterface $exportedOrders
     *
     * @return ExportedOrdersInterface
     */
    public function save(ExportedOrdersInterface $exportedOrders): ExportedOrdersInterface;

    /**
     * @return ExportedOrdersInterface
     */
    public function getLastExportedOrders(): ExportedOrdersInterface;

    /**
     * @param int $id
     *
     * @return array
     */
    public function getByRaportId(int $id): array;
}