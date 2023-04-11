<?php

declare(strict_types=1);

namespace YellowCard\ProductsExporter\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;

class Download extends Action implements HttpGetActionInterface
{
    private const DOWNLOAD_PATH = 'exportedProducts/';
    private const EXTENSION = '.csv';

    public function __construct(
        private readonly FileFactory $fileFactory,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly UrlInterface $url,
        private readonly ResponseInterface $response,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $this->downloadFile();


//        //should without redirect render message, that file was downloaded, or there is no file
        //redirect couses no download, not message
//        $url = $this->url->getUrl('productsexporter/index/index');
//        $this->response->setRedirect($url);
//
//        return $this->response;
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

    private function downloadFile()
    {
        $title =  $this->getRequest()->getParam('title');
        $absoluteFilePath = self::DOWNLOAD_PATH.$title.self::EXTENSION;

        try{
            if(!file_exists($absoluteFilePath)) {
                $notFoundMsg = __('File does not exists, reproces your raport')->render();
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
            $msg = __('File was successfully downloaded')->render();
            $this->messageManager->addSuccessMessage($msg);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong: %1', $e->getMessage()));
        }
    }
}