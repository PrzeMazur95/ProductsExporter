<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Magento\Framework\Model\AbstractModel;
use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

class Export extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(ExportResource::class);
    }
}