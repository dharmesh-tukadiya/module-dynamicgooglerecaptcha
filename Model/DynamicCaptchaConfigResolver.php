<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Model;

use DnTukadiya\DynamicGoogleReCaptcha\Model\DynamicCaptchaFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\Type\Config as ConfigCache;
use Magento\PageCache\Model\Cache\Type as FullPageCache;

class DynamicCaptchaConfigResolver
{
    private $dynamicCaptchaFactory;
    private $configWriter;
    private $fullPageCache;
    private $configCache;
    public const CONFIG_SEPARATOR = '_dynamic_captcha';
    public function __construct(
        DynamicCaptchaFactory $dynamicCaptchaFactory,
        WriterInterface $configWriter,
        ConfigCache $configCache,
        FullPageCache $fullPageCache
    ) {
        $this->dynamicCaptchaFactory = $dynamicCaptchaFactory;
        $this->configWriter = $configWriter;
        $this->configCache = $configCache;
        $this->fullPageCache = $fullPageCache;
    }
    public function execute($modelId)
    {
        $model = $this->dynamicCaptchaFactory->create()->load($modelId);
        if ($model->hasData()) {
            $status = $model->getStatus();
            $identifier = $model->getIdentifier() . self::CONFIG_SEPARATOR;
            $captchaVersion = $model->getCaptchaType();
            $scopeId = $model->getWebsiteId() ?? 0;
            $scopeType = $scopeId == 0 ? ScopeConfigInterface::SCOPE_TYPE_DEFAULT : ScopeInterface::SCOPE_WEBSITE;
            if ($status && !empty($identifier)) {
                $this->configWriter->save('recaptcha_frontend/type_for/' . $identifier, $captchaVersion, $scopeType, $scopeId);
                $this->cleanCache();
            }
        }
    }
    public function delete($identifier, $scopeType, $scopeId)
    {
        if (!empty($identifier)) {
            $identifier = $identifier . self::CONFIG_SEPARATOR;
            $this->configWriter->delete('recaptcha_frontend/type_for/' . $identifier, $scopeType, $scopeId);
            $this->cleanCache();
        }
    }
    public function cleanCache()
    {
        $this->configCache->clean();
        $this->fullPageCache->clean();
    }
}
