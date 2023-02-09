<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Controller\Adminhtml\Index;

 use Magento\Backend\App\Action;
 use Magento\Framework\App\Action\HttpGetActionInterface;
 use Magento\Framework\Controller\ResultFactory;
 use Magento\Framework\View\Result\Page;

 class Index extends Action implements HttpGetActionInterface
 {
     private const MODULE_MENU_ITEM = 'YellowCard_ProductsExporter::grid';
     private const PAGE_TITLE = 'Exported lists';

     /**
      * @return Page
      */
     public function execute(): Page
     {
         /**
          * @var Page $page
          */
         $page =  $this->resultFactory->create(ResultFactory::TYPE_PAGE);
         $page->setActiveMenu(self::MODULE_MENU_ITEM);
         $page->getConfig()->getTitle()->prepend(__(self::PAGE_TITLE));

         return $page;
     }
 }