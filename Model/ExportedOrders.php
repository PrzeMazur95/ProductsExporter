<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Magento\Framework\Model\AbstractModel;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;

class ExportedOrders extends AbstractModel
{
    const ORDERS = 'orders';
    const RAPORT_ID = 'raport_id';
    
    protected function _construct()
    {
        $this->_init(ExportedOrdersResource::class);
    }
}