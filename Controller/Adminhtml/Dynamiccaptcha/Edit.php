<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

class Edit extends \DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha
{

    protected $resultPageFactory;
    public const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_view';
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('dynamic_captcha_id');
        $model = $this->_objectManager->create(\DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Dynamic Captcha no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('dntukadiya_dynamicgooglerecaptcha_dynamic_captcha', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Dynamic Captcha') : __('New Dynamic Captcha'),
            $id ? __('Edit Dynamic Captcha') : __('New Dynamic Captcha')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Dynamic Captchas'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Dynamic Captcha : %1', $model->getIdentifier()) : __('New Dynamic Captcha'));
        return $resultPage;
    }
}

