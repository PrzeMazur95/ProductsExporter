<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service\ObserverServices;

 use Exception;
 use Psr\Log\LoggerInterface;
 use YellowCard\ProductsExporter\Model\ExportFactory;
 use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

 class RaportService
 {
     public function __construct(
         private ExportResource $exportResource,
         private ExportFactory $exportFactory,
         private LoggerInterface $logger
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
         } catch (Exception $exception) {
             $this->logger->critical($exception);
         }
     }
 }