<?php

 declare(strict_types=1);

 namespace YellowCard\ProductsExporter\Service;

 use Magento\Sales\Api\Data\OrderInterface;
 use Magento\Sales\Model\ResourceModel\Order\Collection;
 use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

 class OrderService
 {
    /**
     *
     * @param CollectionFactory $collectionFactory
     * @param StatusService $statusService
     */
     public function __construct(
         private CollectionFactory $collectionFactory,
         private StatusService $statusService
     ) {
     }

     /**
      * Returns collection of orders with specific status provided in config by user
      *
      * @return string
      */
     public function getOrders(): Collection
     {
         $collection = $this->collectionFactory->create();
         $collection->addFieldToFilter('status', $this->statusService->getStatus());
         $collection->addAttributeToSelect(OrderInterface::INCREMENT_ID);

         return $collection;
     }
 }