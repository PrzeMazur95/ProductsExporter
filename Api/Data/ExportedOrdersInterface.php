<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Api\Data;

interface ExportedOrdersInterface
{
    const ORDERS = 'orders';
    const RAPORT_ID = 'raport_id';
    const CREATED_AT = 'created_at';

    /**
     * @return string
     */
    public function getOrders();

    /**
     * @param string $Orders
     * @return $this
     */
    public function setOrders(string $Orders);

    /**
     * @return int
     */
    public function getRaportId();

    /**
     * @param int $raport_id
     * @return $this
     */
    public function setRaportId(int $raport_id);

    /**
     * @return string
     */
    public function getCreatedAt();
}