<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Controller\Adminhtml\Index;

 use Magento\Backend\App\Action;
 use Magento\Backend\App\Action\Context;
 use Magento\Framework\App\Action\HttpGetActionInterface;
 use YellowCard\ProductsExporter\Service\ExportService;

 class Export extends Action implements HttpGetActionInterface
 {

     /**
      * @param ExportService $exportService
      * @param Context       $context
      */
     public function __construct(
         private ExportService $exportService,
         Context $context
     ) {
         parent::__construct($context);
     }

     /**
      * Triggers export of purchased products from provided orders 
      *
      * @return void
      */
     public function execute(): void
     {
         $this->exportService->createExport();
     }
 }