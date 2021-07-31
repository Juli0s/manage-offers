<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Controller\Adminhtml\Uploader;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Image uploader
     * @var ImageUploader
     */
    protected $imageUploader;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var File
     */
    protected $fileIo;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * Upload constructor.
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param Filesystem $filesystem
     * @param File $fileIo
     * @param StoreManagerInterface $storeManager
     * @param DriverInterface $driver
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        Filesystem $filesystem,
        File $fileIo,
        StoreManagerInterface $storeManager,
        DriverInterface $driver
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->filesystem = $filesystem;
        $this->fileIo = $fileIo;
        $this->storeManager = $storeManager;
        $this->driver = $driver;
    }

    /**
     * Upload file controller action.
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $imageUploadId = $this->getRequest()->getParam('param_name', 'image');
        try {
            $imageResult = $this->imageUploader->saveFileToTmpDir($imageUploadId);
            // Upload image folder wise
            $imageName = $imageResult['name'];
            $firstLetter = substr($imageName, 0, 1);
            $secondLetter = substr($imageName, 1, 1);
            $basePath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
                    ->getAbsolutePath() . 'offers/image/';
            $mediaRootDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)
                    ->getAbsolutePath() . 'offers/image/' . $firstLetter . '/' . $secondLetter . '/';
            if (!$this->driver->isDirectory($mediaRootDir)) {
                $this->fileIo->mkdir($mediaRootDir, 0775);
            }
            // Set image name with new name, If image already exist
            $newImageName = $this->updateImageName($mediaRootDir, $imageName);
            $this->fileIo->mv($basePath . $imageName, $mediaRootDir . $newImageName);
            // Upload image folder wise
            $imageResult['cookie'] = [
                'name'     => $this->_getSession()->getName(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain(),
            ];
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $imageResult['name'] = $newImageName;
            $imageResult['file'] = $newImageName;
            $imageResult['url'] = $mediaUrl . 'offers/image/' . $firstLetter . '/' .
                $secondLetter . '/' . $newImageName;
        } catch (Exception $e) {
            $imageResult = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($imageResult);
    }

    /**
     * @param $path
     * @param $fileName
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function updateImageName($path, $fileName): string
    {
        $position = strrpos($fileName, '.');
        $name = $fileName;
        if ($position) {
            $name = substr($fileName, 0, $position);
            $extension = substr($fileName, $position);
        }

        $new_file_path = $path . '/' . $fileName;
        $new_file_name = $fileName;
        $count = 0;
        while ($this->driver->isExists($new_file_path)) {
            $new_file_name = $name . '_' . $count . $extension;
            $new_file_path = $path . '/' . $new_file_name;
            $count++;
        }

        return $new_file_name;
    }
}
