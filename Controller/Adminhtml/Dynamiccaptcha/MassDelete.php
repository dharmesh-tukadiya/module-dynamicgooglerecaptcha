<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha\CollectionFactory;
use DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver;
use Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    protected $dynamicCaptchaConfigResolver;
    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, DynamicCaptchaConfigResolver $dynamicCaptchaConfigResolver)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->dynamicCaptchaConfigResolver = $dynamicCaptchaConfigResolver;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $dynamicCaptcha) {
            $scopeId = $dynamicCaptcha->getWebsiteId() ?? 0;
            $scopeType = $scopeId == 0 ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_WEBSITE;
            $this->dynamicCaptchaConfigResolver->delete($dynamicCaptcha->getIdentifier(), $scopeType, $scopeId);
            $dynamicCaptcha->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
