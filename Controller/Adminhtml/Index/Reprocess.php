<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use YellowCard\ProductsExporter\Api\ExportedOrdersRepositoryInterface;
use YellowCard\ProductsExporter\Service\Reprocess\ReprocessService;

class Reprocess extends Action implements HttpGetActionInterface
{

    /**
     * @param Context                           $context
     * @param ExportedOrdersRepositoryInterface $exportedOrdersRepository
     * @param ReprocessService                  $reprocessService
     */
    public function __construct(
        Context $context,
        private readonly ExportedOrdersRepositoryInterface $exportedOrdersRepository,
        private readonly ReprocessService $reprocessService
    ) {
        parent::__construct($context);
    }

     /**
     * Send to reprocess service data from db about specific raport which was clicked in admin panel to reprocess
     *
     * @return void
     */
    public function execute(): void
    {
        $specificRaport = $this->exportedOrdersRepository->getByRaportId((int)$this->getRequest()->getParam('id'));
        $this->reprocessService->reprocess($specificRaport);
    }
}