<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Observer;

 use Magento\Framework\Event\Observer;
 use Magento\Framework\Event\ObserverInterface;
 use Psr\Log\LoggerInterface;

 class ExportFailed implements ObserverInterface
 {
     public function __construct(private LoggerInterface $logger){}

     public function execute(Observer $observer)
     {
         $this->logger->error('fail from observer');
     }
 }