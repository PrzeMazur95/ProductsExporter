<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service;

 class ProductService
 {
     /**
      * @param OrderService $orderService
      */
     public function __construct(private OrderService $orderService)
     {
     }

     /**
      * Return all products purchased in provided orders
      *
      * @return array
      */
     public function getProducts(): array
     {
         $products = [];
         foreach ($this->orderService->getOrders() as $order) {
             $products[] = $order->getAllVisibleItems();
         }

         return $products;
     }
 }