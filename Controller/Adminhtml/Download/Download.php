<?php

declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Controller\Adminhtml\Download;

 use Exception;
 use Magento\Backend\App\Action;
 use Magento\Backend\App\Action\Context;
 use Magento\Framework\App\Action\HttpGetActionInterface;
 use Magento\Framework\App\Filesystem\DirectoryList;
 use Magento\Framework\App\Response\Http\FileFactory;

 class Download extends Action implements HttpGetActionInterface
 {
     private const DOWNLOAD_PATH = 'exportedProducts/';
     private const EXTENSION = '.csv';

     public function __construct(
         private readonly FileFactory $fileFactory,
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
                 'rm' => false
             ],
             DirectoryList::PUB
         );
     }
 }