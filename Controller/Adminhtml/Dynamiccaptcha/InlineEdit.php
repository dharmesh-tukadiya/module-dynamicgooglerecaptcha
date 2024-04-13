<?php

/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

use Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class InlineEdit extends \Magento\Backend\App\Action
{

    protected $jsonFactory;
    protected $dynamicCaptchaConfigResolver;
    public const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_save';
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver $dynamicCaptchaConfigResolver
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->dynamicCaptchaConfigResolver = $dynamicCaptchaConfigResolver;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    /** @var \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha $model */
                    $model = $this->_objectManager->create(\DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptcha::class)->load($modelid);
                    try {
                        if ($model->hasData()) {
                            $scopeId = $model->getWebsiteId() ?? 0;
                            $scopeType = $scopeId == 0 ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_WEBSITE;
                            $this->dynamicCaptchaConfigResolver->delete($model->getIdentifier(), $scopeType, $scopeId);
                        }
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $model->save();
                        $this->dynamicCaptchaConfigResolver->execute($model->getId());
                    } catch (\Exception $e) {
                        $messages[] = "[Dynamic Captcha ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
