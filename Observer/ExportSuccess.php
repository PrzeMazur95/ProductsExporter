<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Observer;

 use Exception;
 use Magento\Framework\Event\Observer;
 use Magento\Framework\Event\ObserverInterface;
 use YellowCard\ProductsExporter\Service\ObserverServices\RaportService;

 class ExportSuccess implements ObserverInterface
 {
     /**
      * @param RaportService $raportService
      */
     public function __construct(
         private RaportService $raportService
     ) {
     }

     /**
      * @param Observer $observer
      *
      * @return void
      * @throws Exception
      */
     public function execute(Observer $observer)
     {
         $this->raportService->execute();
     }
 }