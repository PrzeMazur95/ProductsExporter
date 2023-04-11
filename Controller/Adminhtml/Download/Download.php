<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

class Download extends Action implements HttpGetActionInterface
{
    private const DOWNLOAD_PATH = 'exportedProducts/';
    private const EXTENSION = '.csv';
    private string $errorMessage;

    /**
     * @param FileFactory          $fileFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface      $logger
     * @param PageFactory          $pageFactory
     * @param Context              $context
     */
    public function __construct(
        private readonly FileFactory $fileFactory,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly LoggerInterface $logger,
        private readonly PageFactory $pageFactory,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Call private method to download export file
     *
     */
    public function execute()
    {
        if(!$this->downloadFile()){
            $this->messageManager->addErrorMessage(__($this->errorMessage));
            $resultPage = $this->pageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('File not found'));

            return $resultPage;
        }
        return true;
    }

    /**
     * Get from configuration, if admin wants to delete file after download or no
     *
     * @return bool
     */
    private function ifFileShouldBeDeleted(): bool
    {
       return (bool)$this->scopeConfig->getValue('yellowcard/general/deleteExportFile');
    }

    /**
     * Trigger download file action
     *
     * @return bool
     */
    private function downloadFile(): bool
    {
        $title =  $this->getRequest()->getParam('title');
        $absoluteFilePath = self::DOWNLOAD_PATH.$title.self::EXTENSION;
        try{
            if(!file_exists($absoluteFilePath)) {
                $this->errorMessage = "File that you want to download does not exist. Please download reprocessed one";

                return false;
            }
            $this->fileFactory->create(
                $title.self::EXTENSION,
                [
                    'type' => 'filename',
                    'value' => $absoluteFilePath,
                    'rm' => $this->ifFileShouldBeDeleted()
                ],
                DirectoryList::PUB
            );
        } catch (Exception $e) {
            $this->logger->error('Something went wrong when downloading export file: %1'. $e->getMessage());
            $this->errorMessage = "Something went wrong when downloading export file. Check log messages";

            return false;
        }
        return true;
    }
}