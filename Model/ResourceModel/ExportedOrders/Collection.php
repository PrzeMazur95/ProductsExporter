<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders;

use YellowCard\ProductsExporter\Model\ExportedOrders;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(ExportedOrders::class, ExportedOrdersResourceModel::class);
    }
}