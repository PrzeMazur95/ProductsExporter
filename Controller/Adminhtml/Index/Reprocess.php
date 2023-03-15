<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Reprocess extends Action implements HttpGetActionInterface
{

    /**
     * @param Context       $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $param = $this->getRequest()->getParam('id');
        $result->setContents($param);

        return $result;
    }
}