<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Export extends Action implements HttpGetActionInterface
{

    /**
     * @param PageFactory   $pageFactory
     * @param Context       $context
     */
    public function __construct(
        private PageFactory $pageFactory,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Triggers export of purchased products from provided orders. For now showing ordered products in admin area
     *
     * @return Page
     */
    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set('Generated Raport');

        return $page;
    }
}