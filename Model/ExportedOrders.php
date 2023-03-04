<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Magento\Framework\Model\AbstractModel;
use YellowCard\ProductsExporter\Api\Data\ExportedOrdersInterface;
use YellowCard\ProductsExporter\Model\ResourceModel\ExportedOrders as ExportedOrdersResource;

class ExportedOrders extends AbstractModel implements ExportedOrdersInterface
{
    const ORDERS = 'orders';
    const RAPORT_ID = 'raport_id';

    protected function _construct()
    {
        $this->_init(ExportedOrdersResource::class);
    }

    /**
     * @return string
     */
    public function getOrders(): string
    {
        return $this->getData(self::ORDERS);
    }

    /**
     * @param string $Orders
     */
    public function setOrders(string $Orders): void
    {
        $this->setData(self::ORDERS, $Orders);
    }

    /**
     * @return int
     */
    public function getRaportId(): int
    {
        return $this->getData(self::RAPORT_ID);
    }

    /**
     * @param int $raport_id
     */
    public function setRaportId(int $raport_id): void
    {
        $this->setData(self::RAPORT_ID, $raport_id);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
       return $this->getData(self::CREATED_AT);
    }
}