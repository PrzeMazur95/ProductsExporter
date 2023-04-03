<?php

 namespace YellowCard\ProductsExporter\Service\Reprocess;

 class LoadProductsService
 {
     /**
      * Reeturn products from given orders
      *
      * @param array $orders
      *
      * @return array
      */
     public function execute(array $orders): array
     {
         $products = [];
         foreach ($orders as $order) {
             $products[] = $order->getAllVisibleItems();
         }

         return $products;
     }
 }