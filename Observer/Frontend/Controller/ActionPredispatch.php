<?php

/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Observer\Frontend\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\ReCaptchaUi\Model\IsCaptchaEnabledInterface;
use Magento\ReCaptchaUi\Model\RequestHandlerInterface;
use Magento\Framework\App\Response\RedirectInterface;
use DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha\CollectionFactory;
use \Magento\Framework\App\Config\ScopeConfigInterface;

class ActionPredispatch implements ObserverInterface
{

    private $redirect;
    private $isCaptchaEnabled;
    private $requestHandler;
    private $collectionFactory;
    private $scopeConfig;
    private $moduleStatus;
    public function __construct(
        IsCaptchaEnabledInterface $isCaptchaEnabled,
        RequestHandlerInterface $requestHandler,
        RedirectInterface $redirect,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->isCaptchaEnabled = $isCaptchaEnabled;
        $this->requestHandler = $requestHandler;
        $this->redirect = $redirect;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->moduleStatus = $this->scopeConfig->getValue('dntukadiya_dynamicgooglerecaptcha/module/status');
    }

    public function execute(Observer $observer): void
    {
        if ($this->moduleStatus) {
            $key = false;
            $request = $observer->getRequest();
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('submit_controller_path', [trim($request->getOriginalPathInfo() ?? ""), trim(rtrim($request->getOriginalPathInfo() ?? "", '/')), trim(ltrim($request->getOriginalPathInfo() ?? "", '/'))]);
            $collection->addFieldToFilter('action_method', $request->getMethod());
            $collection->addFieldToFilter('status', 1);
            if ($collection->count()) {
                $key = $collection->getFirstItem()->getIdentifier() . \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver::CONFIG_SEPARATOR;
            }
            if ($key && $this->isCaptchaEnabled->isCaptchaEnabledFor($key)) {
                /** @var Action $controller */
                $controller = $observer->getControllerAction();
                $request = $controller->getRequest();
                $response = $controller->getResponse();
                $redirectOnFailureUrl = $this->redirect->getRedirectUrl();
                $this->requestHandler->execute($key, $request, $response, $redirectOnFailureUrl);
            }
        }
    }
}
