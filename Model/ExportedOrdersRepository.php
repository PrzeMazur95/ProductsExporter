<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Api\Data\ExportedOrdersInterface;
use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders\CollectionFactory;

class ExportedOrdersRepository implements ExportedOrdersRepositoryInterface
{
    /**
     * @param ExportedOrdersResource $exportedOrdersResource
     * @param LoggerInterface        $logger
     * @param CollectionFactory      $exportedOrdersCollectionFactory
     */
    public function __construct(
        private ExportedOrdersResource $exportedOrdersResource,
        private LoggerInterface $logger,
        private CollectionFactory $exportedOrdersCollectionFactory
    ) {
    }

    /**
     * Save to db an entity with numbers of orders from which export was created
     *
     * @param ExportedOrdersInterface $exportedOrders
     *
     * @return ExportedOrdersInterface
     */
    public function save(ExportedOrdersInterface $exportedOrders
    ): ExportedOrdersInterface {
        try{
            $this->exportedOrdersResource->save($exportedOrders);
        } catch (\Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
        }

        return $exportedOrders;
    }

    /**
     * Return last created entity with exported order numbers
     *
     * @return ExportedOrdersInterface
     */
    public function getLastExportedOrders(): ExportedOrdersInterface
    {
        $lastExportedOrdersCollection = $this->exportedOrdersCollectionFactory->create();
        $lastExportedOrdersCollection->addOrder('id', 'DESC');
        $lastExportedOrdersEntity = $lastExportedOrdersCollection->getFirstItem();

        return $lastExportedOrdersEntity;
    }
}