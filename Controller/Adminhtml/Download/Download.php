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
        $ifReprocessedShouldBeDownloaded = $this->checkIfUserWantsToDownloadReprocessedFile();

        if(!$this->downloadFile($ifReprocessedShouldBeDownloaded)){
            $this->messageManager->addErrorMessage(__($this->errorMessage));
            $resultPage = $this->pageFactory->create();
            $resultPage->getConfig()->getTitle()->set(__('File not found'));

            return $resultPage;
        }
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
     * Check if user clicked download reprocessed file
     *
     * @return bool
     */
    private function checkIfUserWantsToDownloadReprocessedFile(): bool
    {
        return (bool)$this->getRequest()->getParam('reprocess');
    }

    /**
     * Trigger download file action, original or reprocessed
     *
     * @param bool $ifReprocessedShouldBeDownloaded
     *
     * @return bool
     */
    private function downloadFile(bool $ifReprocessedShouldBeDownloaded): bool
    {
        $title =  $this->getRequest()->getParam('title');
        $id = $this->getRequest()->getParam('id');

        ($ifReprocessedShouldBeDownloaded) ?
            $absoluteFilePath = self::DOWNLOAD_PATH.'reprocess_'.$id.self::EXTENSION :
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