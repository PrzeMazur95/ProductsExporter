<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ExportedOrders extends AbstractDb
{
    private const TABLE_NAME = 'yellowcard_exported_orders';
    private const PRIMARY_KEY = 'id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}