<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class PageActions extends Column
{
    const EXPORT_URL_REPROCES = 'productsexporter/index/reprocess';

    public function __construct(
        private readonly urlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['reprocess'] = [
                        'href' => $this->urlBuilder->getUrl(self::EXPORT_URL_REPROCES, ['id' => $item['id']]),
                        'label' => __('Reprocess'),
                    ];
                    $item[$name]['download'] = [
                        'href' => $this->urlBuilder->getUrl(self::EXPORT_URL_REPROCES, ['id' => $item['id']]),
                        'label' => __('Download'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}