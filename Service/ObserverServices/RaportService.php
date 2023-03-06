<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service\ObserverServices;

 use Exception;
 use Psr\Log\LoggerInterface;
 use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
 use YellowCard\ProductsExporter\Model\ExportFactory;
 use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

 class RaportService
 {
     public function __construct(
         private ExportResource $exportResource,
         private ExportFactory $exportFactory,
         private LoggerInterface $logger,
         private ExportedOrdersRepositoryInterface $exportedOrdersRepository
     ) {
     }

     /**
      * @throws Exception
      */
     public function execute(): void
     {
         $this->generateRaport();
     }

     /**
      * @return void
      * @throws Exception
      */
     private function generateRaport(): void
     {
         try{
             $export = $this->exportFactory->create();
             $export->setData('title', 'Raport_from_'.date('Y-m-d', time()));
             $export->setData('status', 'Success');
             $export->setData('created_at', time());

             $this->exportResource->save($export);
            $this->updateExportedOrdersEntity((int)$export->getId());
         } catch (Exception $exception) {
             $this->logger->critical($exception);
         }
     }

    /**
     * Update exported_orders table, with proper raport_id
     *
     * @param int $raportId
     *
     * @return void
     */
    public function updateExportedOrdersEntity(int $raportId): void
    {
        $lastExportedOrders = $this->exportedOrdersRepository->getLastExportedOrders();
        $lastExportedOrders->setRaportId($raportId);
        $this->exportedOrdersRepository->save($lastExportedOrders);
    }
 }