<?php

/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $dynamicCaptchaConfigResolver;
    public const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_save';
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver $dynamicCaptchaConfigResolver
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->dynamicCaptchaConfigResolver = $dynamicCaptchaConfigResolver;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('dynamic_captcha_id');

            $model = $this->_objectManager->create(\DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Dynamic Captcha no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            if ($model->hasData()) {
                $scopeId = $model->getWebsiteId() ?? 0;
                $scopeType = $scopeId == 0 ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_WEBSITE;
                $this->dynamicCaptchaConfigResolver->delete($model->getIdentifier(), $scopeType, $scopeId);
            }
            $model->setData($data);

            try {
                $model->save();
                $this->dynamicCaptchaConfigResolver->execute($model->getId());
                $this->messageManager->addSuccessMessage(__('You saved the Dynamic Captcha.'));
                $this->dataPersistor->clear('dntukadiya_dynamicgooglerecaptcha_dynamic_captcha');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['dynamic_captcha_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Dynamic Captcha.'));
            }

            $this->dataPersistor->set('dntukadiya_dynamicgooglerecaptcha_dynamic_captcha', $data);
            return $resultRedirect->setPath('*/*/edit', ['dynamic_captcha_id' => $this->getRequest()->getParam('dynamic_captcha_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
