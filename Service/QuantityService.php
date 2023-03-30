<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service;

 use Magento\Framework\App\Config\ScopeConfigInterface;

 class QuantityService
 {
     /**
      * @param ScopeConfigInterface $scopeConfig
      */
     public function __construct(private readonly ScopeConfigInterface $scopeConfig)
     {
     }

     /**
      * Returns orders quantity, that client would like to export products from. Provided in module configuration
      *
      * @return string
      */
     public function getOrdersQuantityToExport(): string
     {
         $quantity = $this->scopeConfig->getValue('yellowcard/general/quantity');
         return $quantity;
     }
 }