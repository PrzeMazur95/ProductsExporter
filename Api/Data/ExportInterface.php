<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Api\Data;

interface ExportInterface
{
    const TITLE = 'title';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status);

    /**
     * @return string
     */
    public function getCreatedAt();
}