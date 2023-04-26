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

    /**
     * @return string
     */
    public function getTitle(): string
    {
       return $this->getData(self::TITLE);
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param string $status
     *
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }
}