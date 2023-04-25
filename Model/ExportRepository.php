<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Exception;
use Psr\Log\LoggerInterface;
use YellowCard\ProductsExporter\Api\Data\ExportInterface;
use YellowCard\ProductsExporter\Api\ExportRepositoryInterface;
use YellowCard\ProductsExporter\Enum\LoggerMessages;
use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

class ExportRepository implements ExportRepositoryInterface
{
    /**
     * @param ExportResource  $exportResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ExportResource $exportResource,
        private readonly LoggerInterface $logger
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
        try{
            $this->exportResource->save($export);
        } catch (Exception $exception) {
            $this->logger->critical(LoggerMessages::DB_FAILED->value. " : " .$exception->getMessage());
        }
        return $export;
    }
}