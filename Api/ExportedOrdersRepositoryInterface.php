<?php

namespace YellowCard\ProductsExporter\Api;

use YellowCard\ProductsExporter\Api\Data\ExportedOrdersInterface;

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
}