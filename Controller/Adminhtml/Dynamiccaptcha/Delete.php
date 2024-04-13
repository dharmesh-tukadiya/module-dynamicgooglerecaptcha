<?php

/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

use Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class Delete extends \DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha
{
    private $dynamicCaptchaConfigResolver;
    public const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_delete';
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver $dynamicCaptchaConfigResolver
    ) {
        parent::__construct($context, $coreRegistry);
        $this->dynamicCaptchaConfigResolver = $dynamicCaptchaConfigResolver;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('dynamic_captcha_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha::class);
                $model->load($id);
                $scopeId = $model->getWebsiteId() ?? 0;
                $scopeType = $scopeId == 0 ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_WEBSITE;
                $this->dynamicCaptchaConfigResolver->delete($model->getIdentifier(), $scopeType, $scopeId);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Dynamic Captcha.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['dynamic_captcha_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Dynamic Captcha to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
