<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service;

 class ExportService
 {
     /**
      * @param ProductService $productService
      */
     public function __construct(private ProductService $productService)
     {
     }

     /**
      * Shows on the screen purchases products from provided orders. Sku, quantity and order Id
      *
      * @return void
      */
     public function createExport(): void
     {
         foreach ($this->productService->getProducts() as $product) {
             foreach ($product as $item) {
                 echo $item->getSku()
                     . " " . number_format((float)$item->getQtyOrdered(), 2)
                     . " " . $item->getOrderId() . '</br>';
             }
         }
     }
 }