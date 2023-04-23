<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service\ObserverServices;

 use Exception;
 use Psr\Log\LoggerInterface;
 use YellowCard\ProductsExporter\Api\ExportRepositoryInterface;
 use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
 use YellowCard\ProductsExporter\Model\ExportFactory;

 class RaportService
 {
      /**
      * @param ExportRepositoryInterface         $exportRepository
      * @param ExportFactory                     $exportFactory
      * @param LoggerInterface                   $logger
      * @param ExportedOrdersRepositoryInterface $exportedOrdersRepository
      */
     public function __construct(
        private readonly ExportRepositoryInterface $exportRepository,
        private readonly ExportFactory $exportFactory,
        private readonly LoggerInterface $logger,
        private readonly ExportedOrdersRepositoryInterface $exportedOrdersRepository
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
      * Generate new row in db yellowcard_products_export table,
      * sets date, raport status and title
      *
      * @return void
      * @throws Exception
      */
     private function generateRaport(): void
     {
         try{
            $export = $this->exportFactory->create();

            $export->setTitle('Exported_Products_from_'.date('Y-m-d-h-i', time()));
            $export->setStatus('Success');
            $export->setData(time());
 
            $this->exportRepository->save($export);

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
    private function updateExportedOrdersEntity(int $raportId): void
    {
        $lastExportedOrders = $this->exportedOrdersRepository->getLastExportedOrders();
        $lastExportedOrders->setRaportId($raportId);
        $this->exportedOrdersRepository->save($lastExportedOrders);
    }
 }