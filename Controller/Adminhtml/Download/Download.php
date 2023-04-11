<?php

declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Controller\Adminhtml\Download;

 use Exception;
 use Magento\Backend\App\Action;
 use Magento\Backend\App\Action\Context;
 use Magento\Framework\App\Action\HttpGetActionInterface;
 use Magento\Framework\App\Config\ScopeConfigInterface;
 use Magento\Framework\App\Filesystem\DirectoryList;
 use Magento\Framework\App\Response\Http\FileFactory;

 class Download extends Action implements HttpGetActionInterface
 {
     private const DOWNLOAD_PATH = 'exportedProducts/';
     private const EXTENSION = '.csv';

     public function __construct(
         private readonly FileFactory $fileFactory,
         private readonly ScopeConfigInterface $scopeConfig,
         Context $context
     ) {
         parent::__construct($context);
     }

     /**
      * @throws Exception
      */
     public function execute()
     {
         $title =  $this->getRequest()->getParam('title');
         $absoluteFilePath = self::DOWNLOAD_PATH.$title.self::EXTENSION;

         if(!file_exists($absoluteFilePath)) {
             throw new Exception('not found, to be modified');
         }
         //later set this rm as a config value - if admin wants to delete downloaded file form server after it
         $this->fileFactory->create(
             $title.self::EXTENSION,
             [
                 'type' => 'filename',
                 'value' => $absoluteFilePath,
                 'rm' => $this->ifFileShouldBeDeleted()
             ],
             DirectoryList::PUB
         );
     }

     /**
      * Get from configuration, if admin wants to delete file after download or no
      *
      * @return bool
      */
      private function ifFileShouldBeDeleted(): bool
      {
         return (bool)$this->scopeConfig->getValue('yellowcard/general/deleteExportFile');
      }
 }