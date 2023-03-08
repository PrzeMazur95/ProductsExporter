<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Model;

use Magento\Framework\Model\AbstractModel;
use YellowCard\ProductsExporter\Api\Data\ExportInterface;
use YellowCard\ProductsExporter\Model\ResourceModel\Export as ExportResource;

class Export extends AbstractModel implements ExportInterface
{

    protected function _construct()
    {
        $this->_init(ExportResource::class);
    }

    public function getTitle(): string
    {
       return $this->getData(self::TITLE);
    }

    public function setTitle(string $title): void
    {
        $this->setData(self::TITLE, $title);
    }

    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus(string $status)
    {
        $this->setData(self::STATUS, $status);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }
}