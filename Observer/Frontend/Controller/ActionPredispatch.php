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
use \Magento\Framework\App\CacheInterface;

class ActionPredispatch implements ObserverInterface
{

    private $redirect;
    private $isCaptchaEnabled;
    private $requestHandler;
    private $collectionFactory;
    private $scopeConfig;
    private $moduleStatus;
    private $cache;

    public function __construct(
        IsCaptchaEnabledInterface $isCaptchaEnabled,
        RequestHandlerInterface $requestHandler,
        RedirectInterface $redirect,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        CacheInterface $cache
    ) {
        $this->isCaptchaEnabled = $isCaptchaEnabled;
        $this->requestHandler = $requestHandler;
        $this->redirect = $redirect;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->moduleStatus = $this->scopeConfig->getValue('dntukadiya_dynamicgooglerecaptcha/module/status');
        $this->cache = $cache;
    }

    public function execute(Observer $observer): void
    {
        if ($this->moduleStatus) {
            $key = false;
            $request = $observer->getRequest();
            $controllerPaths = [trim($request->getOriginalPathInfo() ?? ""), trim(rtrim($request->getOriginalPathInfo() ?? "", '/')), trim(ltrim($request->getOriginalPathInfo() ?? "", '/'))];
            $cacheKey = 'dynamicgooglerecaptcha_' . md5(json_encode($controllerPaths));
            $key = $this->cache->load($cacheKey);
            if (empty($key)) {
                $collection = $this->collectionFactory->create();
                $collection->addFieldToFilter('submit_controller_path', $controllerPaths);
                $collection->addFieldToFilter('action_method', $request->getMethod());
                $collection->addFieldToFilter('status', 1);
                if ($collection->count()) {
                    $key = $collection->getFirstItem()->getIdentifier() . \DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaConfigResolver::CONFIG_SEPARATOR;
                }
            }
            if ($key && $key != "0" && $this->isCaptchaEnabled->isCaptchaEnabledFor($key)) {
                $this->cache->save($key, $cacheKey, [], null);
                /** @var Action $controller */
                $controller = $observer->getControllerAction();
                $request = $controller->getRequest();
                $response = $controller->getResponse();
                $redirectOnFailureUrl = $this->redirect->getRedirectUrl();
                $this->requestHandler->execute($key, $request, $response, $redirectOnFailureUrl);
            } else {
                $this->cache->save(0, $cacheKey, [], null);
            }
        }
    }
}
