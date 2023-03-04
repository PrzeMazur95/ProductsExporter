<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Api\Data\ExportedOrdersInterface;
use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;

class ExportedOrdersRepository implements ExportedOrdersRepositoryInterface
{
    public function __construct(
        private ExportedOrdersResource $exportedOrdersResource,
        private LoggerInterface $logger
    ) {
    }

    public function save(ExportedOrdersInterface $exportedOrders
    ): ExportedOrdersInterface {
        try{
            $this->exportedOrdersResource->save($exportedOrders);
        } catch (\Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
        }

        return $exportedOrders;
    }

    public function getLastExportedOrders(): ExportedOrdersInterface
    {
        // TODO: Implement getLastExportedOrders() method.
    }
}