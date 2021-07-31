<?php
/**
 * Copyright (c) 2021 All Rights Reserved.
 * https://opensource.org/licenses/OSL-3.0  Open Software License (OSL 3.0)
 * Julien_ManageOffers
 * Julien TRAJMAN <j.trajman@gmail.com> <@Julien0s>
 */

declare(strict_types=1);

namespace Julien\ManageOffers\Controller\Adminhtml\Offer;

use Julien\ManageOffers\Api\Data\OfferInterface;
use Julien\ManageOffers\Api\Data\OfferInterfaceFactory;
use Julien\ManageOffers\Command\Offer\SaveCommand;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Save Offer controller action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Julien_ManageOffers::management';
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var SaveCommand
     */
    private $saveCommand;
    /**
     * @var OfferInterfaceFactory
     */
    private $entityDataFactory;
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param SaveCommand $saveCommand
     * @param OfferInterfaceFactory $entityDataFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        SaveCommand $saveCommand,
        OfferInterfaceFactory $entityDataFactory,
        TimezoneInterface $timezone
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->saveCommand = $saveCommand;
        $this->entityDataFactory = $entityDataFactory;
        $this->timezone = $timezone;
    }

    /**
     * Save Offer Action.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();

        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->checkDate($params);

            /** @var OfferInterface|DataObject $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($this->getFormData($params));
            $this->saveCommand->execute($entityModel);
            $this->messageManager->addSuccessMessage(
                __('The Offer data was saved successfully')
            );
            $this->dataPersistor->clear('offer');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->dataPersistor->set('offer', $params);

            return $resultRedirect->setPath('*/*/edit', [
                'offer_id' => $params['general']['offer_id']
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param array $params
     * @return mixed
     */
    private function getFormData(array $params)
    {
        $data = $params['general'];

        // Categories
        if (isset($data['categories'])) {
            $categories = $data['categories'];
            $categoryIds = [];
            foreach ($categories as $key => $value) {
                $categoryIds[] = $value;
            }
            unset($data['categories']);
            $data['categories'] = implode(',', $categoryIds);
        }

        // Image
        if (!isset($data['image'])) {
            $data['image'] = null;
            return $data;
        }

        if ($data['image'] && is_array($data['image'])) {
            $data['image'] = $data['image'][0]['url'];
        }

        return $data;
    }

    /**
     * @param array $params
     * @return bool
     * @throws CouldNotSaveException
     */
    private function checkDate(array $params)
    {
        $data = $params['general'];
        $startDate = $this->timezone->date($data['start_date'])->getTimestamp();
        $endDate = $this->timezone->date($data['end_date'])->getTimestamp();

        if ($endDate < $startDate) {
            $errorMessage = __('End date can\'t be before start date');
            throw new CouldNotSaveException($errorMessage);
        }

        return true;
    }
}
